<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $array = [
            'fb',
            'tg',
            'website',
            'client',
            'partner'
        ];
        return [
            'title' => $array[rand(0, count($array) - 1)]
        ];
    }
}
