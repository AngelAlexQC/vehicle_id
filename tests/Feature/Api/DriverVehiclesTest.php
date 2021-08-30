<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriversVehiclesControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_driver_vehicles()
    {
        $driver = Driver::factory()->create();
        $vehicles = Vehicle::factory()
            ->count(2)
            ->create([
                'owner_id' => $driver->id,
            ]);

        $response = $this->getJson(
            route('api.drivers.vehicles.index', $driver)
        );

        $response->assertOk()->assertSee($vehicles[0]->plate);
    }

    /**
     * @test
     */
    public function it_stores_the_driver_vehicles()
    {
        $driver = Driver::factory()->create();
        $data = Vehicle::factory()
            ->make([
                'owner_id' => $driver->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.drivers.vehicles.store', $driver),
            $data
        );

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicle = Vehicle::latest('id')->first();

        $this->assertEquals($driver->id, $vehicle->owner_id);
    }
}
