<?php

namespace App\Models;

use App\Http\Filters\HasFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use Predis\Response\Status;

class Transport extends EloquentModel
{
    use HasFilter;
    use HasFactory;
    use SoftDeletes;

    public const SLIDER_CACHE_KEY = 'transport_items_for_slider';
    public const FAVORITE_CACHE_KEY = 'transport_items_for_favorites';
    public const ADMIN_CACHE_KEY = 'transport_items_for_admin';
    public const DETAIL_CACHE_KEY = 'transport_detail';
    public const FILTER_CACHE_KEY = 'transport_items_for_filter';
    public const CACHE_TIME = 10;

    protected $fillable = [
        'id',
        'active',
        'city',
        'vin',
        'phone',
        'description',
        'engine',
        'power',
        'transmission',
        'drive',
        'mileage',
        'color',
        'steering_wheel',
        'country',
        'tact',
        'fuel_supply_type',
        'doors',
        'seats',
        'price',
        'year',
        'user_id',
        'model_id',
        'maker_id',
        'fuel_type_id',
        'transport_type_id',
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_transport');
    }

    public function transportType(): BelongsTo
    {
        return $this->belongsTo(TransportType::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->maker?->name . ' ' . $this->model?->name
        );
    }

    protected function previewText(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->power . ' л.с, '
                . $this->fuelType?->name ?? '-'
                . ', ' . $this->fuel_supply_type ?? '-'
                . ', ' . $this->mileage . ' км'
        );
    }

    protected function powerFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => number_format($this->power, 0, '.', ' ')
        );
    }

    protected function mileageFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => number_format($this->mileage, 0, '.', ' ')
        );
    }

    protected function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => number_format($this->price, 0, '.', ' ') . ' ₽'
        );
    }
    protected function publishedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => Date::parse($this->published_at)->translatedFormat('d F Y')
        );
    }
    protected function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => Date::parse($this->published_at)->translatedFormat('d F Y')
        );
    }
}
