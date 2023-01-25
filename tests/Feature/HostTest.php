<?php

namespace Tests\Feature;

use App\Models\Host;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class HostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->assertDatabaseCount('hosts', 100);
    }

    public function test_search_hosts_with_national_code()
    {
        // Run seeder and factory to get data
        $host = Host::factory()->create();

        $response = $this->getJson('api/v1/hosts', ['national_code' => $host->national_code]);

        $response->assertStatus(200);

        // Test json structure
        $response->assertJsonStructure([
            'data' => [
                '0' => [
                    'id',
                    'national_code'
                ]
            ]
        ]);
        // national code is unique
        $response->assertJsonCount(1);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->has('data')
                ->first(
                    fn ($json) =>

                    $json->whereType('0.national_code', 'integer')
                        ->has('0.national_code')
                        ->etc()
                )
        );
    }
}
