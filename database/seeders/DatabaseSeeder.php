<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            ReservationSeeder::class,
            ReservationAvailabilitySeeder::class,
            ContactSeeder::class,
        ]);
    }
}