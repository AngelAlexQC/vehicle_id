<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Record;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehiclesRecordsControllerTest extends TestCase
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
    public function it_gets_vehicle_records()
    {
        $vehicle = Vehicle::factory()->create();
        $records = Record::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route('api.vehicles.records.index', $vehicle)
        );

        $response->assertOk()->assertSee($records[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_records()
    {
        $vehicle = Vehicle::factory()->create();
        $data = Record::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.records.store', $vehicle),
            $data
        );

        unset($data['user_id']);
        unset($data['parking_id']);
        unset($data['driver_id']);
        unset($data['vehicle_id']);

        $this->assertDatabaseHas('records', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $record = Record::latest('id')->first();

        $this->assertEquals($vehicle->id, $record->vehicle_id);
    }
}
