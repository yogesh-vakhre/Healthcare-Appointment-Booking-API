<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HealthcareProfessionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $uniqueName = $this->faker->unique->name();
        return [
            'name' => $uniqueName,
            'specialty' => $this->faker->jobTitle(),
        ];
    }
}
