<?php
namespace Database\Factories;

use App\Enums\ReservationStatus;
use App\Enums\ServiceType;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(ReservationStatus::values()),
            'service' => fake()->randomElement(ServiceType::values()),
            'datetime' => fake()->dateTimeBetween('+1 day', '+30 days'),
            'coupon_code' => fake()->optional()->regexify('[A-Z0-9]{8}'),
            'customer_contact' => fake()->optional()->email(),
            'management_notes' => fake()->optional()->sentence(),
            'simple_questionnaire' => fake()->optional()->paragraph(),
            'customer_id' => Customer::factory(),
        ];
    }

    public function application(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReservationStatus::APPLICATION,
        ]);
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReservationStatus::CONFIRMED,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ReservationStatus::REJECTED,
        ]);
    }

    public function tireInstallation(): static
    {
        return $this->state(fn (array $attributes) => [
            'service' => ServiceType::TIRE_INSTALLATION_PURCHASED,
        ]);
    }

    public function oilChange(): static
    {
        return $this->state(fn (array $attributes) => [
            'service' => ServiceType::OIL_CHANGE,
        ]);
    }
}
