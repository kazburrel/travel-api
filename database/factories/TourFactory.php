<?php

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomDate = fake()->date;
        return [
            'id' => Str::uuid(),
            'travel_id' => Travel::inRandomOrder()->first()->id,
            'name' => fake()->text(10),
            'starting_date' => $randomDate,
            'ending_date' => Carbon::parse($randomDate)->addDays(5)->toDateString(),
            'price' => fake()->numberBetween(10, 100),
        ];
    }
}
