<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Record;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersRecordsControllerTest extends TestCase
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
    public function it_gets_user_records()
    {
        $user = User::factory()->create();
        $records = Record::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.records.index', $user));

        $response->assertOk()->assertSee($records[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_records()
    {
        $user = User::factory()->create();
        $data = Record::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.records.store', $user),
            $data
        );

        unset($data['user_id']);
        unset($data['parking_id']);
        unset($data['driver_id']);
        unset($data['vehicle_id']);

        $this->assertDatabaseHas('records', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $record = Record::latest('id')->first();

        $this->assertEquals($user->id, $record->user_id);
    }
}
