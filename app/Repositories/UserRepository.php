<?php

namespace App\Repositories;

use App\Helpers\ClearCache;
use App\Models\Image;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserRepository implements UserRepositoryInterface
{
    protected int $cacheTime = 10;

    public function __construct(protected User $model, protected ClearCache $cacheHelper)
    {
    }

    public function getActiveUsersWithoutCurrentUser(): Collection
    {
        $cacheKey = 'admin_all_users';

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () {
            return $this->model
                ->query()
                ->with(['images'])
                ->whereNot('id', auth()->id())
                ->where('active', true)
                ->get(['id', 'name', 'city', 'email', 'is_admin']);
        });
    }

    public function getCurrentUser(int $id): User
    {
        $cacheKey = 'admin_current_users_' . $id;

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheTime), function () use ($id) {
            return $this->model
                ->query()
                ->with(['images'])
                ->where('active', true)
                ->findOrFail($id, ['id', 'name', 'city', 'email', 'is_admin']);
        });
    }

    public function updateUser(Request $request, int $id): void
    {
        $user = $this->getCurrentUser($id);

        $user->name = $request->name;
        $user->city = $request->city;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        $user->save();

        $imageUser = null;
        if ($request->file('images')) {
            if ($user->images->count() > 0) {
                $imageUser = $user->images[0];
            }

            if ($imageUser && $imageUser->id) {
                Storage::disk('public')->delete($imageUser->image_path);
                Image::query()->find($imageUser->id)->delete();
            }

            foreach ($request->file('images') as $imageFile) {
                $image_path = Storage::disk('public')->put('images/users', $imageFile[0]);
                $image = Image::query()->create([
                    'image_title' => $imageFile[0]->getClientOriginalName(),
                    'image_path' => $image_path,
                    'image_size' => $imageFile[0]->getSize(),
                    'image_ext' => $imageFile[0]->getMimeType(),
                    'image_source' => 'users',
                ]);
                $user->images()->attach($image->id);
            }
        } elseif (count($request->images) == 0) {
            $imageUser = $user->images[0];

            if ($imageUser && $imageUser->id) {
                Storage::disk('public')->delete($imageUser->image_path);
                Image::query()->find($imageUser->id)->delete();
            }
        }

        $this->cacheHelper->removeSectionCache(['admin_all_users', 'admin_current_users_' . $id]);
    }

    public function deactivationUser(int $id): void
    {
        $this->model
            ->query()
            ->where(['id' => $id])
            ->update(['active' => false]);

        $this->cacheHelper->removeSectionCache('admin_all_users');
    }
}
