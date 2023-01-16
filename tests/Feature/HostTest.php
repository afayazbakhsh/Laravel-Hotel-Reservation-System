<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class HostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_hosts()
    {
        $response = $this->get('/api/v1/hosts');

        $response->assertJsonCount(100, 'data');

        $response->assertJson(
            fn (AssertableJson $json) =>

            $json
                ->has('data', 100)
                ->has(
                    'data.0',
                    fn ($json) =>
                    $json->where('id', 1)
                        ->whereType('national_code', 'integer')
                        ->has('hotel')
                        ->whereType('hotel.is_confirm', 'boolean')
                        ->etc()
                )
        );
        $response->assertStatus(200);
    }
}
