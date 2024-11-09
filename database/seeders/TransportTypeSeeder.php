<?php

namespace Database\Seeders;

use App\Models\TransportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transportTypes = [
            'Автомобиль',
            'Мотоцикл',
            'Спецтехника',
            'Грузовой автомобиль',
            'Водная техника',
        ];

        foreach ($transportTypes as $transportType) {
            TransportType::factory()->create([
                'name' => $transportType
            ]);
        }
    }
}
