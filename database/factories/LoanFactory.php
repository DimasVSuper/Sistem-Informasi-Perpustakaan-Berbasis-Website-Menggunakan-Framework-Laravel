<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrow_date = fake()->dateTimeBetween('-30 days', 'now');
        $due_date = (new \DateTime($borrow_date->format('Y-m-d')))->modify('+7 days');

        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'borrow_date' => $borrow_date,
            'due_date' => $due_date,
            'return_date' => null,
            'status' => fake()->randomElement(['pending', 'approved', 'overdue', 'returned']),
            'fine_amount' => 0,
        ];
    }

    /**
     * State untuk loan yang sudah dikembalikan
     */
    public function returned(): static
    {
        $borrow_date = fake()->dateTimeBetween('-60 days', '-30 days');
        $due_date = (new \DateTime($borrow_date->format('Y-m-d')))->modify('+7 days');
        $return_date = fake()->dateTimeBetween($due_date->format('Y-m-d'), 'now');

        return $this->state(fn (array $attributes) => [
            'borrow_date' => $borrow_date,
            'due_date' => $due_date,
            'return_date' => $return_date,
            'status' => 'returned',
            'fine_amount' => 0,
        ]);
    }

    /**
     * State untuk loan yang pending
     */
    public function pending(): static
    {
        $borrow_date = fake()->dateTimeBetween('-3 days', 'now');
        $due_date = (new \DateTime($borrow_date->format('Y-m-d')))->modify('+7 days');

        return $this->state(fn (array $attributes) => [
            'borrow_date' => $borrow_date,
            'due_date' => $due_date,
            'return_date' => null,
            'status' => 'pending',
            'fine_amount' => 0,
        ]);
    }

    /**
     * State untuk loan yang approved/active
     */
    public function active(): static
    {
        $borrow_date = fake()->dateTimeBetween('-15 days', '-3 days');
        $due_date = (new \DateTime($borrow_date->format('Y-m-d')))->modify('+7 days');

        return $this->state(fn (array $attributes) => [
            'borrow_date' => $borrow_date,
            'due_date' => $due_date,
            'return_date' => null,
            'status' => 'approved',
            'fine_amount' => 0,
        ]);
    }

    /**
     * State untuk loan yang overdue
     */
    public function overdue(): static
    {
        $borrow_date = fake()->dateTimeBetween('-30 days', '-15 days');
        $due_date = (new \DateTime($borrow_date->format('Y-m-d')))->modify('+7 days');
        $days_overdue = fake()->numberBetween(1, 10);
        $fine_amount = $days_overdue * 5000;

        return $this->state(fn (array $attributes) => [
            'borrow_date' => $borrow_date,
            'due_date' => $due_date,
            'return_date' => null,
            'status' => 'overdue',
            'fine_amount' => min($fine_amount, 100000), // max fine 100000
        ]);
    }
}

