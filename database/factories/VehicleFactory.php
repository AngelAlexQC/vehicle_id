<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plate' => $this->faker->text(7),
            'brand' => $this->faker->name,
            'registration' => $this->faker->text(10),
            'model' => $this->faker->name,
            'owner_id' => \App\Models\Driver::factory(),
        ];
    }
}
