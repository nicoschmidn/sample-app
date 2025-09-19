<?php

namespace Database\Factories;

use App\Models\Sample;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sample>
 */
class SampleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Sample::CSV_HEADER_NAME => $this->faker->word(),
            Sample::CSV_HEADER_TYPE => $this->faker->word(),
            Sample::CSV_HEADER_LOCATION => $this->faker->country(),
        ];
    }
}
