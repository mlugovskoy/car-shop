<?php

namespace App\Http\Controllers;

use App\Helpers\ClearCache;
use App\Http\Resources\TransportResource;
use App\Repositories\TransportRepository;

class AdminTransportController extends Controller
{
    protected TransportRepository $transportRepository;

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
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
