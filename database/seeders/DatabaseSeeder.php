<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Driver::create([
            'dni' => '0850539479',
            'name', 'Ángel Alexander',
            'surname' => 'Quiroz Candela',
            'email' => 'admin@admin.com',
            'phone' => '0939851015'
        ]);
        Vehicle::create([
            'brand' => 'Chevrolet',
            'model' => 'Impala 67',
            'owner_id' => 1,
            'plate' => 'MBF-5630',
            'registration' => 'EC1234567890X'
        ]);
        // Adding an admin user
        /* $user = User::create([
            'name', 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        $this->call(PermissionsSeeder::class); */

        /*  $this->call(ParkingSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(RecordSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DriverSeeder::class); */
    }
}
