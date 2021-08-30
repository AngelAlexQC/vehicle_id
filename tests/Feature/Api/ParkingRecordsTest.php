<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Record;
use App\Models\Parking;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParkingsRecordsControllerTest extends TestCase
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
    public function it_gets_parking_records()
    {
        $parking = Parking::factory()->create();
        $records = Record::factory()
            ->count(2)
            ->create([
                'parking_id' => $parking->id,
            ]);

        $response = $this->getJson(
            route('api.parkings.records.index', $parking)
        );

        $response->assertOk()->assertSee($records[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_parking_records()
    {
        $parking = Parking::factory()->create();
        $data = Record::factory()
            ->make([
                'parking_id' => $parking->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.parkings.records.store', $parking),
            $data
        );

        unset($data['user_id']);
        unset($data['parking_id']);
        unset($data['driver_id']);
        unset($data['vehicle_id']);

        $this->assertDatabaseHas('records', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $record = Record::latest('id')->first();

        $this->assertEquals($parking->id, $record->parking_id);
    }
}
