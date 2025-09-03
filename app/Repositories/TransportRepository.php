<?php

namespace App\Repositories;

use App\Http\Requests\Transports\TransportsCreateRequest;
use App\Models\FuelType;
use App\Models\Image;
use App\Models\Maker;
use App\Models\Model;
use App\Models\Transport;
use App\Models\TransportType;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Services\CacheService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Http\Filters\TransportsFilters;
use App\Repositories\Contracts\TransportRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class TransportRepository implements TransportRepositoryInterface
{
    public function __construct(protected Transport $model)
    {
    }

    public function getTopSliderTransports(int $limit = 15): Collection
    {
        $item = $this->model
            ->query()
            ->with(['maker', 'model', 'images'])
            ->where('active', true)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get(['id', 'city', 'model_id', 'maker_id', 'price']);

        return CacheService::save($item, $this->model::SLIDER_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getTransportsOfFavorites(?array $favorites): Collection
    {
        $item = $this->model
            ->query()
            ->with(['maker', 'model', 'fuelType', 'user', 'images'])
            ->whereIn('id', $favorites)
            ->orderBy('published_at', 'desc')
            ->get([
                'id',
                'active',
                'maker_id',
                'model_id',
                'fuel_type_id',
                'transport_type_id',
                'city',
                'year',
                'power',
                'engine',
                'fuel_supply_type',
                'mileage',
                'price',
                'description',
                'user_id',
                'published_at'
            ]);

        return CacheService::save($item, $this->model::FAVORITE_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function getAllTransportsToAdmin(): Collection
    {
        $item = $this->model
            ->query()
            ->with(['maker', 'model', 'fuelType', 'user', 'images'])
            ->orderBy('published_at', 'desc')
            ->get([
                'id',
                'active',
                'maker_id',
                'model_id',
                'fuel_type_id',
                'transport_type_id',
                'city',
                'year',
                'power',
                'engine',
                'fuel_supply_type',
                'mileage',
                'price',
                'description',
                'user_id',
                'published_at'
            ]);

        return CacheService::save($item, $this->model::ADMIN_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function paginateTransports(Collection $newsCollection, int $perPage = 5): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $newsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator(
            $currentPageItems,
            $newsCollection->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query()
            ]
        );
    }

    public function getAllTransportsToFilters(TransportsFilters $filters, ?Maker $maker): Collection
    {
        return $this->model
            ->query()
            ->with(['maker', 'model', 'fuelType', 'user', 'images'])
            ->where('active', true)
            ->when($maker, fn($query) => $query->where('maker_id', $maker->id))
            ->orderBy('published_at', 'desc')
            ->filter($filters)
            ->get([
                'id',
                'maker_id',
                'model_id',
                'fuel_type_id',
                'transport_type_id',
                'city',
                'year',
                'power',
                'engine',
                'fuel_supply_type',
                'mileage',
                'price',
                'description',
                'user_id',
                'published_at'
            ]);
    }

    public function getOneTransportToFilters(?Maker $maker, int $id): Transport
    {
        $item = $this->model
            ->query()
            ->with(['maker', 'model', 'fuelType', 'user', 'images'])
            ->where('active', true)
            ->where('id', $id)
            ->when($maker, fn($query) => $query->where('maker_id', $maker->id))
            ->orderBy('published_at', 'desc')
            ->first([
                'id',
                'maker_id',
                'model_id',
                'fuel_type_id',
                'transport_type_id',

                'year',
                'city',
                'power',
                'engine',
                'transmission',
                'drive',
                'mileage',
                'color',
                'steering_wheel',
                'phone',
                'price',
                'description',

                'fuel_supply_type',
                'user_id',
                'published_at'
            ]);

        return CacheService::save($item, $this->model::DETAIL_CACHE_KEY . "_$id", $this->model::CACHE_TIME);
    }

    public function getFieldsToFilters(): array
    {
        $transports = $this->model
            ->query()
            ->where('active', true)
            ->get();

        $makers = $transports
            ->pluck('maker')
            ->unique()
            ->whereNotNull()
            ->map(fn($maker) => ['value' => $maker['name']])
            ->values()
            ->all();

        $models = $transports
            ->pluck('model')
            ->unique()
            ->whereNotNull()
            ->map(fn($model) => ['value' => $model['name']])
            ->values()
            ->all();

        $steeringWheel = $transports
            ->pluck('steering_wheel')
            ->unique()
            ->whereNotNull()
            ->map(fn($steeringWheel) => $steeringWheel)
            ->values()
            ->all();

        $transmission = $transports
            ->pluck('transmission')
            ->unique()
            ->whereNotNull()
            ->map(fn($transmission) => ['value' => $transmission])
            ->values()
            ->all();

        $drive = $transports
            ->pluck('drive')
            ->unique()
            ->whereNotNull()
            ->map(fn($drive) => ['value' => $drive])
            ->values()
            ->all();

        $color = $transports
            ->pluck('color')
            ->unique()
            ->whereNotNull()
            ->map(fn($color) => ['value' => $color])
            ->values()
            ->all();

        $fuelType = $transports
            ->pluck('fuelType')
            ->unique()
            ->whereNotNull()
            ->map(fn($fuelType) => ['value' => $fuelType['name']])
            ->values()
            ->all();

        $transportType = $transports
            ->pluck('transportType')
            ->unique()
            ->whereNotNull()
            ->map(fn($transportType) => ['value' => $transportType['name']])
            ->values()
            ->all();

        $year = $transports
            ->pluck('year')
            ->unique()
            ->whereNotNull()
            ->sort()
            ->map(fn($year) => ['value' => $year])
            ->values()
            ->all();

        $items = [
            'makers' => $makers,
            'models' => $models,
            'steeringWheel' => $steeringWheel,
            'transmission' => $transmission,
            'drive' => $drive,
            'color' => $color,
            'fuelType' => $fuelType,
            'transportType' => $transportType,
            'year' => $year
        ];

        return CacheService::save($items, $this->model::FILTER_CACHE_KEY, $this->model::CACHE_TIME);
    }

    public function storeTransport(TransportsCreateRequest $request): Transport
    {
        $transport = $this->model
            ->query()
            ->create([
                'active' => false,
                'city' => $request->city,
                'vin' => $request->vin,
                'phone' => $request->phone,
                'description' => $request->description,
                'engine' => $request->engine,
                'power' => $request->power,
                'transmission' => $request->transmission,
                'drive' => $request->drive,
                'mileage' => $request->mileage,
                'color' => $request->color,
                'steering_wheel' => $request->steering_wheel,
                'country' => $request->country,
                'tact' => $request->tact,
                'fuel_supply_type' => $request->fuel_supply_type,
                'doors' => $request->doors,
                'seats' => $request->seats,
                'price' => $request->price,
                'year' => $request->year,
                'model_id' => Model::query()
                    ->where('name', 'ilike', $request->models)
                    ->pluck('id')
                    ->first(),
                'maker_id' => Maker::query()
                    ->where('name', 'ilike', $request->makers)
                    ->pluck('id')
                    ->first(),
                'fuel_type_id' => FuelType::query()
                    ->where('name', 'ilike', $request->fuel_type_id)
                    ->pluck('id')
                    ->first(),
                'transport_type_id' => TransportType::query()
                    ->where(
                        'name',
                        'ilike',
                        $request->transport_type_id
                    )
                    ->pluck('id')
                    ->first(),
                'user_id' => auth()->id(),
                'published_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $image_path = Storage::disk('public')->put('images/transports', $imageFile);
                $image = Image::query()
                    ->create([
                        'image_title' => $imageFile->getClientOriginalName(),
                        'image_path' => $image_path,
                        'image_size' => $imageFile->getSize(),
                        'image_ext' => $imageFile->getMimeType(),
                        'image_source' => 'transports',
                    ]);
                $transport->images()->attach($image->id);
            }
        }

        CacheService::deleteItems([$this->model::FILTER_CACHE_KEY, $this->model::ADMIN_CACHE_KEY]);

        return $transport;
    }

    public function findTransport(int $id): Transport
    {
        return $this->model
            ->query()
            ->findOrFail($id);
    }

    public function getMakerIdsAttachedTransports(): Collection
    {
        return $this->model
            ->query()
            ->where('active', true)
            ->pluck('maker_id');
    }

    public function updateTransport(Transport $transportCollection): void
    {
        $transportCollection->update(['active' => !$transportCollection->active]);

        $user = User::query()->find($transportCollection->user_id);
        $user->notify(
            new DatabaseNotification(
                'Администратор изменил статус вашего объявления '
                . '<b>' . $transportCollection->maker->name . '</b>'
                . ' '
                . '<b>' . $transportCollection->model->name . '</b>'
            )
        );

        CacheService::deleteItem($this->model::ADMIN_CACHE_KEY);
    }

    public function destroyTransport(int $id): void
    {
        $transport = $this->model
            ->query()
            ->with(['maker', 'model'])
            ->find($id);

        $user = User::query()->find($transport->user_id);
        $user->notify(
            new DatabaseNotification(
                'Администратор удалил ваше объявление'
                . '<b>' . $transport->maker->name . '</b>'
                . ' '
                . '<b>' . $transport->model->name . '</b>'
            )
        );

        $this->model
            ->query()
            ->where(['id' => $id])
            ->delete();

        CacheService::deleteItem($this->model::ADMIN_CACHE_KEY);
    }
}
