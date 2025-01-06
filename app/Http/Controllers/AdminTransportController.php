<?php

namespace App\Http\Controllers;

use App\Services\AdminTransportService;
use Illuminate\Http\Request;

class AdminTransportController extends Controller
{
    protected AdminTransportService $adminTransportService;

    public function __construct(AdminTransportService $adminTransportService)
    {
        $this->adminTransportService = $adminTransportService;
    }

    public function index()
    {
        $users = $this->adminTransportService->getAllTransports();

        return inertia(
            'Profile/Admin/Transports/Index', ['items' => $users]
        );
    }

//    public function show($id)
//    {
//        $user = $this->adminTransportService->getCurrentTransport($id);
//
//        return inertia(
//            'Profile/Admin/Transports/Show', ['item' => $user]
//        );
//    }
//
//    public function update(Request $request, $id)
//    {
//        $this->adminTransportService->updateTransport($request, $id);
//
//        $this->adminTransportService->removeCacheCurrentTransport($id);
//
//        $this->adminTransportService->removeCacheAllTransports();
//
//        return redirect()->route('admin.transports')->with('success', "Объявление #$id обновлено.");
//    }
//
//    public function destroy($id)
//    {
//        $this->adminTransportService->deactivationTransport($id);
//
//        $this->adminTransportService->removeCacheAllTransports();
//
//        return redirect()->route('admin.transports')->with('success', "Объявление #$id удалено.");
//    }

}
