<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;

use App\Models\Driver;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehiclesControllerTest extends TestCase
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
    public function it_gets_vehicles_list()
    {
        $vehicles = Vehicle::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.vehicles.index'));

        $response->assertOk()->assertSee($vehicles[0]->plate);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle()
    {
        $data = Vehicle::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.vehicles.store'), $data);

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $driver = Driver::factory()->create();

        $data = [
            'plate' => $this->faker->text(7),
            'brand' => $this->faker->name,
            'registration' => $this->faker->text(10),
            'model' => $this->faker->name,
            'owner_id' => $driver->id,
        ];

        $response = $this->putJson(
            route('api.vehicles.update', $vehicle),
            $data
        );

        $data['id'] = $vehicle->id;

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->deleteJson(route('api.vehicles.destroy', $vehicle));

        $this->assertDeleted($vehicle);

        $response->assertNoContent();
    }
}
