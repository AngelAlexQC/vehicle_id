<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Parking;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParkingsControllerTest extends TestCase
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
    public function it_gets_parkings_list()
    {
        $parkings = Parking::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.parkings.index'));

        $response->assertOk()->assertSee($parkings[0]->tag);
    }

    /**
     * @test
     */
    public function it_stores_the_parking()
    {
        $data = Parking::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.parkings.store'), $data);

        $this->assertDatabaseHas('parkings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_parking()
    {
        $parking = Parking::factory()->create();

        $data = [
            'tag' => $this->faker->name,
            'location' => $this->faker->text(10),
        ];

        $response = $this->putJson(
            route('api.parkings.update', $parking),
            $data
        );

        $data['id'] = $parking->id;

        $this->assertDatabaseHas('parkings', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_parking()
    {
        $parking = Parking::factory()->create();

        $response = $this->deleteJson(route('api.parkings.destroy', $parking));

        $this->assertDeleted($parking);

        $response->assertNoContent();
    }
}
