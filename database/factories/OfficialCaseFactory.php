<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employer;
use App\Models\OfficialCase;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficialCaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OfficialCase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => 'suspended',
            'company_id' => Company::query()->inRandomOrder()->first()->id,
            'suspension_date' => $this->faker->dateTimeBetween('-1 year'),
            'lifted_date' => null,
            'days_suspended' => $this->faker->numberBetween(1,40),
            'employer_id' => Employer::query()->inRandomOrder()->first()->id,
            'case_officer' => $this->faker->name(),
            'worker_id' => Worker::query()->inRandomOrder()->first()->id,
            'atnsia_no' => $this->faker->buildingNumber(),
            'complaint_id' => null,
            'complaint' => $this->faker->paragraph(),
            'remarks' => $this->faker->paragraph(),
        ];
    }
}
