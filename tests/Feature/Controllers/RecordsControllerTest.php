<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Record;

use App\Models\Driver;
use App\Models\Parking;
use App\Models\Vehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordsControllerTest extends TestCase
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
    public function it_displays_index_view_with_records()
    {
        $records = Record::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('records.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.records.index')
            ->assertViewHas('records');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_record()
    {
        $response = $this->get(route('records.create'));

        $response->assertOk()->assertViewIs('app.records.create');
    }

    /**
     * @test
     */
    public function it_stores_the_record()
    {
        $data = Record::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('records.store'), $data);

        $this->assertDatabaseHas('records', $data);

        $record = Record::latest('id')->first();

        $response->assertRedirect(route('records.edit', $record));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_record()
    {
        $record = Record::factory()->create();

        $response = $this->get(route('records.show', $record));

        $response
            ->assertOk()
            ->assertViewIs('app.records.show')
            ->assertViewHas('record');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_record()
    {
        $record = Record::factory()->create();

        $response = $this->get(route('records.edit', $record));

        $response
            ->assertOk()
            ->assertViewIs('app.records.edit')
            ->assertViewHas('record');
    }

    /**
     * @test
     */
    public function it_updates_the_record()
    {
        $record = Record::factory()->create();

        $user = User::factory()->create();
        $parking = Parking::factory()->create();
        $driver = Driver::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $data = [
            'user_id' => $user->id,
            'parking_id' => $parking->id,
            'driver_id' => $driver->id,
            'vehicle_id' => $vehicle->id,
        ];

        $response = $this->put(route('records.update', $record), $data);

        $data['id'] = $record->id;

        $this->assertDatabaseHas('records', $data);

        $response->assertRedirect(route('records.edit', $record));
    }

    /**
     * @test
     */
    public function it_deletes_the_record()
    {
        $record = Record::factory()->create();

        $response = $this->delete(route('records.destroy', $record));

        $response->assertRedirect(route('records.index'));

        $this->assertDeleted($record);
    }
}
