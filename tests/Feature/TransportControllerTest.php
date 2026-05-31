<?php

use App\Models\Maker;
use App\Models\Transport;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('index возвращает страницу со списком транспорта', function () {
    Transport::factory()->count(3)->create(['active' => true]);

    $response = $this->get(route('transport.index'));

    $response->assertStatus(200)
        ->assertInertia(
            fn($page) => $page
                ->component('Transport/Index')
                ->has('transports')
                ->has('countTransports')
                ->has('favorites')
                ->has('fieldsFilters')
                ->has('breadcrumbs')
        );
});

test('index показывает только активный транспорт', function () {
    Transport::factory()->count(2)->create(['active' => true]);
    Transport::factory()->count(3)->create(['active' => false]);

    $response = $this->get(route('transport.index'));

    $response->assertStatus(200)
        ->assertInertia(
            fn($page) => $page
                ->component('Transport/Index')
                ->where('countTransports', 2)
        );
});

test('show возвращает страницу с деталями транспорта', function () {
    $maker = Maker::factory()->create(['name' => 'Toyota']);
    $transport = Transport::factory()->create([
        'active' => true,
        'maker_id' => $maker->id
    ]);

    $response = $this->get(route('transport.show', ['section' => 'Toyota', 'id' => $transport->id]));

    $response->assertStatus(200)
        ->assertInertia(
            fn($page) => $page
                ->component('Transport/Show')
                ->has('transport')
                ->has('breadcrumbs')
                ->has('isFavorite')
        );
});
