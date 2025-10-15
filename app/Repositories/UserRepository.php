<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\CacheInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model, private CacheInterface $cache)
    {
    }

    public function getActiveUsersWithoutCurrentUser(): Collection
    {
        $item = $this->model
            ->query()
            ->with(['images'])
            ->whereNot('id', auth()->id())
            ->where('active', true)
            ->get(['id', 'name', 'city', 'email', 'is_admin']);

        return $this->cache->save($item, $this->model::ADMIN_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getCurrentUser(int $id): User
    {
        $item = $this->model
            ->query()
            ->with(['images'])
            ->where('active', true)
            ->findOrFail($id, ['id', 'name', 'city', 'email', 'is_admin']);

        return $this->cache->save($item, $this->model::CURRENT_CACHE_KEY . "_$id", $this->model::CACHE_TIME);
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

        $user->notify(
            new DatabaseNotification(
                "Администратор изменил ваш аккаунт"
            )
        );

        $this->cache->deleteItems([$this->model::ADMIN_CACHE_KEY, $this->model::CURRENT_CACHE_KEY]);
    }

    public function deactivationUser(int $id): void
    {
        $this->model
            ->query()
            ->where(['id' => $id])
            ->update(['active' => false]);

        $this->cache->deleteItem($this->model::ADMIN_CACHE_KEY);
    }
}
