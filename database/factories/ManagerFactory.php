<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'salary' => $this->faker->randomFloat(),
            'plain' => [
                'quarter_1' => 10000,
                'quarter_2' => 20000,
                'quarter_3' => 30000,
                'quarter_4' => 40000
                ]
        ];
    }
}
