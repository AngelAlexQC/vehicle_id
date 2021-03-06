<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Record;

use App\Models\Driver;
use App\Models\Parking;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
    public function it_gets_records_list()
    {
        $records = Record::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.records.index'));

        $response->assertOk()->assertSee($records[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_record()
    {
        $data = Record::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.records.store'), $data);

        $this->assertDatabaseHas('records', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.records.update', $record), $data);

        $data['id'] = $record->id;

        $this->assertDatabaseHas('records', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_record()
    {
        $record = Record::factory()->create();

        $response = $this->deleteJson(route('api.records.destroy', $record));

        $this->assertDeleted($record);

        $response->assertNoContent();
    }
}
