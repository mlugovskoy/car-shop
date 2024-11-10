<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuelTypes = [
            'Бензин',
            'Дизель',
            'Биодизель',
            'Пропан',
            'Электро',
        ];

        foreach ($fuelTypes as $fuelType) {
            FuelType::factory()->create([
                'name' => $fuelType
            ]);
        }
    }
}
