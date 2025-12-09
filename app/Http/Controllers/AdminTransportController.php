<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransportResource;
use App\Repositories\Contracts\TransportRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminTransportController extends Controller
{
    public function __construct(private TransportRepositoryInterface $transportRepository)
    {
    }

    public function index(): Response|ResponseFactory
    {
        $transports = $this->transportRepository
            ->paginateTransports($this->transportRepository->getAllTransportsToAdmin(), 10);

        return inertia(
            'Profile/Admin/Transports/Index',
            ['items' => TransportResource::collection($transports)]
        );
    }

    public function update($id): RedirectResponse
    {
        $resTransport = $this->transportRepository->findTransport($id);

        $this->transportRepository->updateTransport($resTransport);

        return redirect()->route('admin.transports')->with('success', "Объявление #$id обновлено.");
    }

    public function destroy($id): RedirectResponse
    {
        $this->transportRepository->destroyTransport($id);

        return redirect()->route('admin.transports')->with('success', "Объявление #$id удалено.");
    }
}
