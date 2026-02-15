<?php

namespace App\Http\Controllers;

use App\Facades\SiteSettings;
use App\Http\Requests\SiteSettingsUpdateRequest;
use App\Repositories\Contracts\SiteSettingsRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Inertia\ResponseFactory;

class SiteSettingsController extends Controller
{
    public function __construct(private SiteSettingsRepositoryInterface $repository)
    {
    }

    public function index(): Response|ResponseFactory
    {
        return inertia('Profile/Admin/Settings/Index', [
            'settings' => SiteSettings::get()[0]
        ]);
    }

    public function update(SiteSettingsUpdateRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $this->repository->update($data);
            Session::flash('flash', "Настройки сайта сохранены.");
        } catch (\Exception $e) {
            Session::flash('flash', "Произошла ошибка при сохранении: " . $e->getMessage());
        }

        return redirect()->back();
    }
}
