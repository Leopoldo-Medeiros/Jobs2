<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Employer; // Ensure you import Employer if used in factory
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class; // Specify the model this factory is for

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'employer_id' => Employer::factory(), // This will create an employer if it doesn't exist
            'salary' => '$' . number_format($this->faker->numberBetween(50000, 150000), 0, '.', ',')
        ];
    }
}
