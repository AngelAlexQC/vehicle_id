<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Parking;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParkingsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
    public function it_displays_index_view_with_parkings()
    {
        $parkings = Parking::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('parkings.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.parkings.index')
            ->assertViewHas('parkings');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_parking()
    {
        $response = $this->get(route('parkings.create'));

        $response->assertOk()->assertViewIs('app.parkings.create');
    }

    /**
     * @test
     */
    public function it_stores_the_parking()
    {
        $data = Parking::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('parkings.store'), $data);

        $this->assertDatabaseHas('parkings', $data);

        $parking = Parking::latest('id')->first();

        $response->assertRedirect(route('parkings.edit', $parking));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_parking()
    {
        $parking = Parking::factory()->create();

        $response = $this->get(route('parkings.show', $parking));

        $response
            ->assertOk()
            ->assertViewIs('app.parkings.show')
            ->assertViewHas('parking');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_parking()
    {
        $parking = Parking::factory()->create();

        $response = $this->get(route('parkings.edit', $parking));

        $response
            ->assertOk()
            ->assertViewIs('app.parkings.edit')
            ->assertViewHas('parking');
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

        $response = $this->put(route('parkings.update', $parking), $data);

        $data['id'] = $parking->id;

        $this->assertDatabaseHas('parkings', $data);

        $response->assertRedirect(route('parkings.edit', $parking));
    }

    /**
     * @test
     */
    public function it_deletes_the_parking()
    {
        $parking = Parking::factory()->create();

        $response = $this->delete(route('parkings.destroy', $parking));

        $response->assertRedirect(route('parkings.index'));

        $this->assertDeleted($parking);
    }
}
