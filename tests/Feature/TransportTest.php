<?php

use App\Models\FuelType;
use App\Models\Image;
use App\Models\Maker;
use App\Models\Model;
use App\Models\Transport;
use App\Models\TransportType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('транспорт создается с нужными полями', function () {
    $user = User::factory()->create();

    $transport = Transport::factory()->create([
        'user_id' => $user->id,
        'price' => 1500000,
        'mileage' => 50000
    ]);

    assertDatabaseHas('transports', [
        'id' => $transport->id,
        'price' => 1500000,
        'mileage' => 50000,
        'user_id' => $user->id
    ]);
});

test('удаленный транспорт не появляется в обычных запросах', function () {
    $transport = Transport::factory()->create();
    $transportId = $transport->id;

    $transport->delete();

    expect(Transport::query()->find($transportId))->toBeNull()
        ->and(Transport::withTrashed()->find($transportId))->not->toBeNull();
});

test('transport принадлежит user', function () {
    $user = User::factory()->create();
    $transport = Transport::factory()->create([
        'user_id' => $user->id
    ]);

    expect($transport->user)->toBeInstanceOf(User::class)
        ->and($transport->user->id)->toBe($user->id);
});

test('transport принадлежит несколько images', function () {
    $images = Image::factory()->count(3)->create();
    $transport = Transport::factory()->create();

    $transport->images()->attach($images->pluck('id'));

    expect($transport->images)->toHaveCount(3);
});

test('transport принадлежит transport_type', function () {
    $transportType = TransportType::factory()->create();
    $transport = Transport::factory()->create([
        'transport_type_id' => $transportType->id
    ]);

    expect($transport->transportType)->toBeInstanceOf(TransportType::class)
        ->and($transport->transportType->id)->toBe($transportType->id);
});

test('transport принадлежит model', function () {
    $model = Model::factory()->create();
    $transport = Transport::factory()->create([
        'model_id' => $model->id
    ]);

    expect($transport->model)->toBeInstanceOf(Model::class)
        ->and($transport->model->id)->toBe($model->id);
});

test('transport принадлежит maker', function () {
    $maker = Maker::factory()->create();
    $transport = Transport::factory()->create([
        'maker_id' => $maker->id
    ]);

    expect($transport->maker)->toBeInstanceOf(Maker::class)
        ->and($transport->maker->id)->toBe($maker->id);
});

test('transport принадлежит fuel_type', function () {
    $fuelType = FuelType::factory()->create();
    $transport = Transport::factory()->create([
        'fuel_type_id' => $fuelType->id
    ]);

    expect($transport->fuelType)->toBeInstanceOf(FuelType::class)
        ->and($transport->fuelType->id)->toBe($fuelType->id);
});


test('title возвращает имя maker и model', function () {
    $maker = Maker::factory()->create(['name' => 'Toyota']);
    $model = Model::factory()->create(['name' => 'Camry']);

    $transport = Transport::factory()->create([
        'maker_id' => $maker->id,
        'model_id' => $model->id
    ]);

    expect($transport->title)->toBe('Toyota Camry');
});

test('preview_text формируется из power, fuel_type, fuel_supply_type, mileage', function () {
    $fuelType = FuelType::factory()->create(['name' => 'Бензин']);

    $transport = Transport::factory()->create([
        'power' => 20,
        'mileage' => 50000,
        'fuel_supply_type' => 'Карбюратор',
        'fuel_type_id' => $fuelType->id
    ]);

    expect($transport->preview_text)->toBe('20 л.с, Бензин, Карбюратор, 50000 км');
});

test('power, mileage, price форматируются с пробелами', function () {
    $transport = Transport::factory()->create([
        'power' => 20000,
        'mileage' => 50000,
        'price' => 1500000
    ]);

    expect($transport->power_formatted)->toBe('20 000')
        ->and($transport->mileage_formatted)->toBe('50 000')
        ->and($transport->price_formatted)->toBe('1 500 000 ₽');
});

test('published_at_formatted форматирует дату публикации', function () {
    $transport = Transport::factory()->create([
        'published_at' => '26.05.2026'
    ]);

    expect($transport->published_at_formatted)->toBe('26 мая 2026');
});

test('created_at_formatted форматирует дату создания', function () {
    $transport = Transport::factory()->create([
        'published_at' => '10.01.2026',
        'created_at' => '25.05.2026'
    ]);

    expect($transport->created_at_formatted)->toBe('25 мая 2026');
});
