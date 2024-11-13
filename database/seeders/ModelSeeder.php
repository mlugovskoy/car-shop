<?php

namespace Database\Seeders;

use App\Models\Maker;
use App\Models\Model;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Mazda3',
            'Mazda6',
            'CX-5',
            'Demio',
            'Axela',
            'Mazda',
            'X-Trail',
            'Note',
            'Qashqai',
            'Juke',
            'Teana',
            'Fit',
            'Vezel',
            'CR-V',
            'Freed',
            'Fit Shuttle',
            '2107',
            'Гранта',
            'Terios Kid',
            'Move',
            'Rocky',
            'RX300',
            'LX570',
            'X5',
            'X6',
            'C-Class',
            'E-Class',
            'Rio'
        ];

        foreach ($models as $model) {
            $makerCount = Maker::query()->count();
            $maker = Maker::query()->where('id', rand(1, $makerCount))->first();

            Model::factory()->create([
                'name' => $model,
                'maker_id' => $maker->id
            ]);
        }
    }
}
