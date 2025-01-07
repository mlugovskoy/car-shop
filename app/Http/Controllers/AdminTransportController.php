<?php

namespace App\Http\Controllers;

use App\Helpers\RemoveSectionCache;
use App\Services\AdminTransportService;

class AdminTransportController extends Controller
{
    protected AdminTransportService $adminTransportService;

    public function __construct(AdminTransportService $adminTransportService)
    {
        $this->adminTransportService = $adminTransportService;
    }

    public function index()
    {
        $transports = $this->adminTransportService->getAllTransports();

        return inertia(
            'Profile/Admin/Transports/Index', ['items' => $transports]
        );
    }

    public function update($id)
    {
        $this->adminTransportService->updateTransport($id);

        (new RemoveSectionCache())->removeSectionCache(['admin_all_transports', 'top_slider_transports']);

        return redirect()->route('admin.transports')->with('success', "Объявление #$id обновлено.");
    }

    public function destroy($id)
    {
        $this->adminTransportService->destroyTransport($id);

        (new RemoveSectionCache())->removeSectionCache(['admin_all_transports', 'top_slider_transports']);

        return redirect()->route('admin.transports')->with('success', "Объявление #$id удалено.");
    }

}
