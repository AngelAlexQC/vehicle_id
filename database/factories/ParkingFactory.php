<?php

namespace Database\Factories;

use App\Models\Parking;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tag' => $this->faker->name,
            'location' => $this->faker->text(10),
        ];
    }
}
