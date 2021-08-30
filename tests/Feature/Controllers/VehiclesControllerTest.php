<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vehicle;

use App\Models\Driver;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehiclesControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_vehicles()
    {
        $vehicles = Vehicle::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('vehicles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicles.index')
            ->assertViewHas('vehicles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_vehicle()
    {
        $response = $this->get(route('vehicles.create'));

        $response->assertOk()->assertViewIs('app.vehicles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle()
    {
        $data = Vehicle::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('vehicles.store'), $data);

        $this->assertDatabaseHas('vehicles', $data);

        $vehicle = Vehicle::latest('id')->first();

        $response->assertRedirect(route('vehicles.edit', $vehicle));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.show', $vehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicles.show')
            ->assertViewHas('vehicle');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.edit', $vehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicles.edit')
            ->assertViewHas('vehicle');
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

        $response = $this->put(route('vehicles.update', $vehicle), $data);

        $data['id'] = $vehicle->id;

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertRedirect(route('vehicles.edit', $vehicle));
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->delete(route('vehicles.destroy', $vehicle));

        $response->assertRedirect(route('vehicles.index'));

        $this->assertDeleted($vehicle);
    }
}
