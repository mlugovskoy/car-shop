<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminUserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getActiveUsersWithoutCurrentUser();

        return inertia(
            'Profile/Admin/Users/Index', ['items' => AdminUserResource::collection($users)]
        );
    }

    public function show($id)
    {
        $user = $this->userRepository->getCurrentUser($id);

        return inertia(
            'Profile/Admin/Users/Show', ['item' => new AdminUserResource($user)]
        );
    }

    public function update(Request $request, $id)
    {
        $this->userRepository->updateUser($request, $id);

        return redirect()->route('admin.users')->with('success', "Пользователь #$id обновлен.");
    }

    public function destroy($id)
    {
        $this->userRepository->deactivationUser($id);

        return redirect()->route('admin.users')->with('success', "Пользователь #$id удален.");
    }
}
