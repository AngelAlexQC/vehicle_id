<?php

namespace Database\Seeders;

use App\Models\Parking;
use Illuminate\Database\Seeder;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Parking::create([
                'tag' => 'Parqueadero ' . $i,
                'location' => 'Calle de prueba ' . $i,
            ]);
        }
    }
}
