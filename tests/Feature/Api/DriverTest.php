<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Driver;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriversControllerTest extends TestCase
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
    public function it_gets_drivers_list()
    {
        $drivers = Driver::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.drivers.index'));

        $response->assertOk()->assertSee($drivers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_driver()
    {
        $data = Driver::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.drivers.store'), $data);

        $this->assertDatabaseHas('drivers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.drivers.update', $driver), $data);

        $data['id'] = $driver->id;

        $this->assertDatabaseHas('drivers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_driver()
    {
        $driver = Driver::factory()->create();

        $response = $this->deleteJson(route('api.drivers.destroy', $driver));

        $this->assertDeleted($driver);

        $response->assertNoContent();
    }
}
