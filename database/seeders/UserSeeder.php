<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Создаем администратора, если его еще нет
        if (!User::where('email', 'admin@sozvezdie-vkusov.ru')->exists()) {
            User::create([
             'full_name' => 'Главный Администратор',
             'email' => 'admin@sozvezdie-vkusov.ru',
             'phone' => '+79990001122',
             'password' => Hash::make('Zvezd@Vkus2024#Adm!n'),
             'is_admin' => true,
             'email_verified_at' => now(),
]);

            $this->command->info(' Создан администратор');
            $this->command->info('Администратор: admin@sozvezdie-vkusov.ru / Zvezd@Vkus2024#Adm!n');
        } else {
            $this->command->info('Администратор уже существует');
        }
    }
}