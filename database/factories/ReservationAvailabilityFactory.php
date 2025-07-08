<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationAvailabilityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'time' => fake()->randomElement(['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00']),
            'is_available' => fake()->boolean(80), // 80% true
            'reason' => fake()->optional()->sentence(),
        ];
    }

    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => true,
            'reason' => null,
        ]);
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
            'reason' => fake()->randomElement([
                'Maintenance scheduled',
                'Staff meeting',
                'Equipment maintenance',
                'Holiday closure',
            ]),
        ]);
    }
}
