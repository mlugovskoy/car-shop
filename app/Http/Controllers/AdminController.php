<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\ResponseFactory;

class AdminController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Profile/Admin/Index', ['items' => []]);
    }
}
