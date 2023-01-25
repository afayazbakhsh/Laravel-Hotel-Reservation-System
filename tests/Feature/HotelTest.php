<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_api_create_hotel()
    {
        $hotel = [
            "name" => "amir is here",
            "city_id" => City::all()->random()->id,
            "emails" =>["test111@gmail.com"],
        ];

        $response = $this->postJson('api/v1/hosts/1/hotels', $hotel);

        $response->assertStatus(201);
        $this->assertDatabaseHas('hotels', $hotel = ['name' => $hotel['name'], 'city_id' => $hotel['city_id']]);
    }
}
