<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Driver;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriversControllerTest extends TestCase
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
    public function it_displays_index_view_with_drivers()
    {
        $drivers = Driver::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('drivers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.drivers.index')
            ->assertViewHas('drivers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_driver()
    {
        $response = $this->get(route('drivers.create'));

        $response->assertOk()->assertViewIs('app.drivers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_driver()
    {
        $data = Driver::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('drivers.store'), $data);

        $this->assertDatabaseHas('drivers', $data);

        $driver = Driver::latest('id')->first();

        $response->assertRedirect(route('drivers.edit', $driver));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_driver()
    {
        $driver = Driver::factory()->create();

        $response = $this->get(route('drivers.show', $driver));

        $response
            ->assertOk()
            ->assertViewIs('app.drivers.show')
            ->assertViewHas('driver');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_driver()
    {
        $driver = Driver::factory()->create();

        $response = $this->get(route('drivers.edit', $driver));

        $response
            ->assertOk()
            ->assertViewIs('app.drivers.edit')
            ->assertViewHas('driver');
    }

    /**
     * @test
     */
    public function it_updates_the_driver()
    {
        $driver = Driver::factory()->create();

        $data = [
            'dni' => $this->faker->shuffle('1234567890'),
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];

        $response = $this->put(route('drivers.update', $driver), $data);

        $data['id'] = $driver->id;

        $this->assertDatabaseHas('drivers', $data);

        $response->assertRedirect(route('drivers.edit', $driver));
    }

    /**
     * @test
     */
    public function it_deletes_the_driver()
    {
        $driver = Driver::factory()->create();

        $response = $this->delete(route('drivers.destroy', $driver));

        $response->assertRedirect(route('drivers.index'));

        $this->assertDeleted($driver);
    }
}
