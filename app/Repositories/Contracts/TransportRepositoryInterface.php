<?php

namespace App\Repositories\Contracts;

use App\Http\Filters\TransportsFilters;
use App\Http\Requests\Transports\TransportsCreateRequest;
use App\Models\Maker;
use App\Models\Transport;
use Illuminate\Support\Collection;

interface TransportRepositoryInterface
{
    public function getTopSliderTransports(int $limit);

    public function getAllTransportsToAdmin();

    public function getTransportsOfFavorites(?array $favorites);

    public function paginateTransports(Collection $transportCollection, int $perPage);

    public function paginateTransportsToFilters(TransportsFilters $filters, ?Maker $maker, int $perPage = 10);

    public function getOneTransportToFilters(?Maker $maker, int $id);

    public function getFieldsToFilters();

    public function storeTransport(TransportsCreateRequest $request);

    public function findTransport(int $id);

    public function getMakerIdsAttachedTransports();

    public function updateTransport(Transport $transportCollection);

    public function destroyTransport(int $id);
}
