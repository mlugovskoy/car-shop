<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransportResource;
use App\Repositories\Contracts\TransportRepositoryInterface;

class AdminTransportController extends Controller
{
    public function __construct(private TransportRepositoryInterface $transportRepository)
    {
    }

    public function index()
    {
        $transports = $this->transportRepository->paginateTransports(
            $this->transportRepository->getAllTransportsToAdmin(),
            10
        );

        return inertia(
            'Profile/Admin/Transports/Index', ['items' => TransportResource::collection($transports)]
        );
    }

    public function update($id)
    {
        $resTransport = $this->transportRepository->findTransport($id);

        $this->transportRepository->updateTransport($resTransport);

        return redirect()->route('admin.transports')->with('success', "Объявление #$id обновлено.");
    }

    public function destroy($id)
    {
        $this->transportRepository->destroyTransport($id);

        return redirect()->route('admin.transports')->with('success', "Объявление #$id удалено.");
    }

}
