<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getActiveUsersWithoutCurrentUser();

    public function getCurrentUser(int $id);

    public function updateUser(Request $request, int $id);

    public function deactivationUser(int $id);
}
