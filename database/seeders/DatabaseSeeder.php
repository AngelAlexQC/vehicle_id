<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $path = 'database/seeders/drivers.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Drives table seeded!');
        $this->call(ParkingSeeder::class);
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
