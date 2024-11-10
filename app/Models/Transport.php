<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
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

    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_transport');
    }

    public function transportType(): BelongsTo
    {
        return $this->belongsTo(TransportType::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
}
