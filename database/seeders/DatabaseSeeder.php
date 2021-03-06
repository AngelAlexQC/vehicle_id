<?php

namespace Database\Seeders;

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
        // Adding an admin user
        $user = \App\Models\User::create([
            'name', 'Ángel Quiroz',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        $this->call(PermissionsSeeder::class);

        /*  $this->call(ParkingSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(RecordSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DriverSeeder::class); */
    }
}
