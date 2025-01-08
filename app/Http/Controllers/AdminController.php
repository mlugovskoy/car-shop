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
}
