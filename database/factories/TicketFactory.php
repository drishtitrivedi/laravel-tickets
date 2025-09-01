<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->randomLetter(),
            'body' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['open', 'closed']),
            'category' => $this->faker->randomElement(['Bug','Feature','Improvment','Task','Epic','Support']),
            'notes' => $this->faker->realText(10),
            'explanation' => $this->faker->word(),
            'confidence' => $this->faker->randomFloat(2, 0, 1),
        ];
    }
}
