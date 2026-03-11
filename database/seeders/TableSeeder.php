<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // создаём столики 1..12, все на 1-4, депозит 2000
        for ($i = 1; $i <= 12; $i++) {
            Table::updateOrCreate(
                ['number' => $i],
                [
                    'seats_min' => 1,
                    'seats_max' => 4,
                    'deposit_per_person' => 2000,
                    'active' => true,
                ]
            );
        }
    }
}