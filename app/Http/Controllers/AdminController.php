<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return inertia(
            'Profile/Admin/Index', ['items' => []]
        );
    }

    public function news()
    {
        return inertia(
            'Profile/Admin/Index', ['items' => []]
        );
    }
}
