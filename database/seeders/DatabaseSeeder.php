<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = User::factory()
            ->count(1)
            ->create([
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
