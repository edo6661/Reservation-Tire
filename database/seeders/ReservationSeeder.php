<?php
namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Customer;
use App\Enums\ReservationStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            $reservationCount = rand(1, 3);
            
            for ($i = 0; $i < $reservationCount; $i++) {
                Reservation::factory()->create([
                    'customer_id' => $customer->id,
                    'status' => fake()->randomElement(ReservationStatus::values()),
                    'service' => fake()->randomElement(ServiceType::values()),
                    'datetime' => fake()->dateTimeBetween('+1 day', '+30 days')
                        ->setTime(
                            fake()->randomElement([10, 11, 12, 13, 14, 15, 16, 17]),
                            0
                        ),
                ]);
            }
        }

        if ($customers->count() > 0) {
            $firstCustomer = $customers->first();
            
            Reservation::factory()->confirmed()->create([
                'customer_id' => $firstCustomer->id,
                'service' => ServiceType::TIRE_INSTALLATION_PURCHASED,
                'datetime' => now()->addDays(3)->setTime(10, 0),
                'coupon_code' => 'SAVE20',
                'simple_questionnaire' => 'Vehicle: Toyota Camry 2020, Tire size: 225/65R17',
            ]);

            Reservation::factory()->application()->create([
                'customer_id' => $firstCustomer->id,
                'service' => ServiceType::OIL_CHANGE,
                'datetime' => now()->addDays(7)->setTime(14, 0),
                'simple_questionnaire' => 'Vehicle: Honda Civic 2019, Last oil change: 3 months ago',
            ]);
        }
    }
}