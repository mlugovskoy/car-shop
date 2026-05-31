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
            'Mazda3' => 'Mazda',
            'Mazda6' => 'Mazda',
            'CX-5' => 'Mazda',
            'Demio' => 'Mazda',
            'Axela' => 'Mazda',
            'X-Trail' => 'Nissan',
            'Note' => 'Nissan',
            'Qashqai' => 'Nissan',
            'Juke' => 'Nissan',
            'Teana' => 'Nissan',
            'Fit' => 'Honda',
            'Vezel' => 'Honda',
            'CR-V' => 'Honda',
            'Freed' => 'Honda',
            'Fit Shuttle' => 'Honda',
            '2107' => 'Лада',
            'Гранта' => 'Лада',
            'Terios Kid' => 'Daithatsu',
            'Move' => 'Daithatsu',
            'Rocky' => 'Daithatsu',
            'RX300' => 'Lexus',
            'LX570' => 'Lexus',
            'X5' => 'BMW',
            'X6' => 'BMW',
            'C-Class' => 'Mercedes-Benz',
            'E-Class' => 'Mercedes-Benz',
            'Rio' => 'Kia',
            'Solaris' => 'Hyundai',
            'Tucson' => 'Hyundai',
            'Creta' => 'Hyundai',
            'CS35' => 'Changan',
            'CS55' => 'Changan',
            'Eado' => 'Changan',
            'Swift' => 'Suzuki',
            'Vitara' => 'Suzuki',
            'Jimny' => 'Suzuki',
            'Camry' => 'Toyota',
            'Corolla' => 'Toyota',
            'Land Cruiser' => 'Toyota',
            'Forester' => 'Subaru',
            'Outback' => 'Subaru',
            'Impreza' => 'Subaru',
            'Focus' => 'Ford',
            'Explorer' => 'Ford',
            'Ranger' => 'Ford',
            'Patriot' => 'УАЗ',
            'Hunter' => 'УАЗ',
            'D-Max' => 'Isuzu',
            'Trooper' => 'Isuzu'
        ];

        $makers = Maker::query()->pluck('id', 'name');

        foreach ($models as $model => $maker) {
            Model::query()->create([
                'name' => $model,
                'maker_id' => $makers[$maker]
            ]);
        }
    }
}
