<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::pluck('id')->all(); // Get all user IDs
        $healthcare_professional_id = User::pluck('id')->all(); // Get all healthcare_professional_id IDs
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'healthcare_professional_id' => $this->faker->randomElement($healthcare_professional_id),
            'appointment_start_time' =>$this->faker->dateTimeBetween('-1 week', '+1 week'),
            'appointment_end_time' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'status' => $this->faker->randomElement(['booked', 'completed', 'cancelled']),
        ];
    }
}
