<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $degree = $this->faker->randomElement([
            'none',
            'candidate',
            'doctor'
        ]);
        return [
            'name' => $this->faker->name($gender),
            'gender' => $gender,
            'degree' => $degree,
            'profile_doctors_id' => DB::table('profile_doctors')->inRandomOrder()->first()->id,
            'date_started_working' => $this->faker->date(),
        ];
    }
}
