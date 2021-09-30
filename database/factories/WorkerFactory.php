<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'        => $this->faker->firstName(),
            'middle_name'       => $this->faker->lastName(),
            'last_name'         => $this->faker->lastName(),
            'birth_date'        => $this->faker->date(),
            'gender'            => $this->faker->randomElement(['m', 'f']),
            'passport'          => $this->faker->creditCardNumber(),
            'email'             => $this->faker->safeEmail(),
            'phone'             => $this->faker->phoneNumber(),
            'iqama'             => $this->faker->creditCardNumber(),
            'current_address'   => $this->faker->address(),
            'permanent_address' => $this->faker->address(),
        ];
    }
}
