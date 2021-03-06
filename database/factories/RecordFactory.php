<?php

namespace Database\Factories;

use App\Models\Record;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Record::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'parking_id' => \App\Models\Parking::factory(),
            'driver_id' => \App\Models\Driver::factory(),
            'vehicle_id' => \App\Models\Vehicle::factory(),
        ];
    }
}
