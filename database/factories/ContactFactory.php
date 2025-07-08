<?php
namespace Database\Factories;

use App\Enums\ContactSituation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reception_id' => User::factory(),
            'title' => fake()->sentence(),
            'text' => fake()->paragraph(),
            'sender' => fake()->email(),
            'answer_title' => fake()->optional()->sentence(),
            'answer_text' => fake()->optional()->paragraph(),
            'situation' => fake()->randomElement(ContactSituation::values()),
        ];
    }

    public function answered(): static
    {
        return $this->state(fn (array $attributes) => [
            'situation' => ContactSituation::ANSWERED,
            'answer_title' => fake()->sentence(),
            'answer_text' => fake()->paragraph(),
        ]);
    }

    public function unanswered(): static
    {
        return $this->state(fn (array $attributes) => [
            'situation' => ContactSituation::UNANSWERED,
            'answer_title' => null,
            'answer_text' => null,
        ]);
    }
}