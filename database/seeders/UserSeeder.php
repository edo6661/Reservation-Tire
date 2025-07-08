<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        User::factory()->customer()->count(10)->create();
    }
}
