<?php

namespace App\Services;

use App\Models\Transport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AdminTransportService
{
    public function getAllTransports()
    {
        $cacheKey = 'admin_all_transports';

//        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            $users = Transport::query()
                ->with(['maker', 'model', 'fuelType', 'user', 'images'])
                ->where('active', true)
                ->orderBy('published_at', 'desc')
                ->get([
                    'id',
                    'maker_id',
                    'model_id',
                    'fuel_type_id',
                    'transport_type_id',
                    'city',
                    'year',
                    'power',
                    'engine',
                    'fuel_supply_type',
                    'mileage',
                    'price',
                    'description',
                    'user_id',
                    'published_at'
                ]);

            foreach ($users as $user) {
                foreach ($user->images as $key => $image) {
                    $user->images[$key]['image_path'] = asset(Storage::url($image->image_path));
                }
            }
            return $users;
//        });
    }

//    public function getCurrentUser($id)
//    {
//        $cacheKey = 'admin_current_users_' . $id;
//
//        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id) {
//            $user = User::query()
//                ->with(['images'])
//                ->where('id', $id)
//                ->where('active', true)
//                ->first(['id', 'name', 'city', 'email', 'is_admin']);
//
//            foreach ($user->images as $key => $image) {
//                $user->images[$key]['image_path'] = asset(Storage::url($image->image_path));
//            }
//
//            return $user;
//        });
//    }
//
//    public function updateUser($request, $id)
//    {
//        $user = User::query()->with(['images'])->findOrFail($id);
//
//        $user->name = $request->name;
//        $user->city = $request->city;
//        $user->email = $request->email;
//        $user->is_admin = $request->is_admin;
//        $user->save();
//
//        $imageUser = null;
//
//        if ($user->images->count() > 0) {
//            $imageUser = $user->images[0];
//        }
//
//        if ($imageUser && $imageUser->id) {
//            Storage::disk('public')->delete($imageUser->image_path);
//            Image::query()->find($imageUser->id)->delete();
//        }
//
//        if ($request->file('images')) {
//            foreach ($request->file('images') as $imageFile) {
//                $image_path = Storage::disk('public')->put('images/users', $imageFile[0]);
//                $image = Image::query()->create([
//                    'image_title' => $imageFile[0]->getClientOriginalName(),
//                    'image_path' => $image_path,
//                    'image_size' => $imageFile[0]->getSize(),
//                    'image_ext' => $imageFile[0]->getMimeType(),
//                    'image_source' => 'users',
//                ]);
//                $user->images()->attach($image->id);
//            }
//        }
//    }
//
//    public function deactivationUser($id)
//    {
//        User::query()
//            ->where(['id' => $id])
//            ->update(['active' => false]);
//    }
//
//    public function removeCacheAllUsers(): void
//    {
//        $cacheKey = 'admin_all_users';
//
//        if (Cache::has($cacheKey)) {
//            Cache::forget($cacheKey);
//        }
//    }
//
//    public function removeCacheCurrentUser($id): void
//    {
//        $cacheKey = 'admin_current_users_' . $id;
//
//        if (Cache::has($cacheKey)) {
//            Cache::forget($cacheKey);
//        }
//    }
}
