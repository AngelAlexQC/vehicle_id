<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Driver;
use App\Models\Record;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriversRecordsControllerTest extends TestCase
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
    public function it_gets_driver_records()
    {
        $driver = Driver::factory()->create();
        $records = Record::factory()
            ->count(2)
            ->create([
                'driver_id' => $driver->id,
            ]);

        $response = $this->getJson(route('api.drivers.records.index', $driver));

        $response->assertOk()->assertSee($records[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_driver_records()
    {
        $driver = Driver::factory()->create();
        $data = Record::factory()
            ->make([
                'driver_id' => $driver->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.drivers.records.store', $driver),
            $data
        );

        unset($data['user_id']);
        unset($data['parking_id']);
        unset($data['driver_id']);
        unset($data['vehicle_id']);

        $this->assertDatabaseHas('records', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $record = Record::latest('id')->first();

        $this->assertEquals($driver->id, $record->driver_id);
    }
}
