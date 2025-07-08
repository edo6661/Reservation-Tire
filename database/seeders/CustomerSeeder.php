<?php
namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customerUsers = User::where('role', UserRole::CUSTOMER)->get();

        foreach ($customerUsers as $user) {
            Customer::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
