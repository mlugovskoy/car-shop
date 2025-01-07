<?php

namespace App\Http\Controllers;

use App\Services\AdminUserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected AdminUserService $adminUserService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function index()
    {
        $users = $this->adminUserService->getAllUsers();

        return inertia(
            'Profile/Admin/Users/Index', ['items' => $users]
        );
    }

    public function show($id)
    {
        $user = $this->adminUserService->getCurrentUser($id);

        return inertia(
            'Profile/Admin/Users/Show', ['item' => $user]
        );
    }

    public function update(Request $request, $id)
    {
        $this->adminUserService->updateUser($request, $id);

        $this->adminUserService->removeCacheCurrentUser($id);

        $this->adminUserService->removeCacheAllUsers();

        return redirect()->route('admin.users')->with('success', "Пользователь #$id обновлен.");
    }

    public function destroy($id)
    {
        $this->adminUserService->deactivationUser($id);

        $this->adminUserService->removeCacheAllUsers();

        return redirect()->route('admin.users')->with('success', "Пользователь #$id удален.");
    }
}
