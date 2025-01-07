<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'city' => 'Город админа',
            'is_admin' => true,
            'password' => 'test',
        ]);

        User::factory()->create([
            'name' => 'Тестовый пользователь',
            'email' => 'test@example.com',
            'city' => 'Тестовый город',
            'is_admin' => false,
            'password' => 'test',
        ]);

        User::factory()->create([
            'name' => 'Московский аккаунт',
            'email' => 'moscow@example.com',
            'city' => 'Москва',
            'is_admin' => false,
            'password' => 'test',
        ]);
    }
}
