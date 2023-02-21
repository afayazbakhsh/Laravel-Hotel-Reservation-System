<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Host;
use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_api_get_all_hotels_without_filters()
    {

        $response = $this->getJson('api/v1/hotels');
        $response
            ->assertStatus(200);

        // Test json structure
        $response->assertJsonStructure([
            'data' => [
                '0' => [
                    'id',
                    'name',
                    'city',
                    'address',
                    'emails',
                    'host',
                ]
            ]
        ]);
    }

    public function test_api_get_hotels_through_city()
    {

        $hotel = Hotel::factory()->create();
        $this->assertModelExists($hotel);

        $response = $this->getJson('api/v1/hotels?city=' . $hotel->city_id . '')
            ->assertStatus(200)
            ->assertJsonPath('data.0.city.id', $hotel->city_id);

        // Test json structure
        $response->assertJsonStructure([
            'data' => [
                '0' => [
                    'city' => [
                        'id',
                        'name'
                    ]
                ]
            ]
        ]);
    }


    public function test_api_get_hotels_through_search()
    {
        $hotel = Hotel::factory()->create();
        $response = $this->getJson('api/v1/hotels?s=' . $hotel->name . '')
            ->assertStatus(200);
    }

    public function test_api_hotel_show_successful()
    {
        $host = Host::factory()->create();
        $hotel = Hotel::factory()->create();

        $response = $this->getJson('api/v1/hotels/' . $hotel->id);
        $response->assertOk();
        $response->assertJsonMissingPath('created_at');
        $response->assertJsonStructure([

            'id',
            'name',
        ]);
    }

    public function test_api_hotel_show_not_successful()
    {

        $hotelId = 00000;

        $response = $this->getJson('api/v1/hotels/' . $hotelId);
        $response->assertNotFound();
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('message')
        );
    }


    public function test_api_store_hotel_successful()
    {
        Storage::fake('avatars');

        $hotel = [
            "name" => "amir",
            "city_id" => City::all()->random()->id,
            "host_id" => Host::all()->random()->id,
            'title' => 'amir_fayaz',
            'slug' => 'test wwtets',
            'motto' => 'test wtets',
            'description' => 'twwwwwwest tets wwedsw',
            "emails" => ["test11111@gmail.com"],
            'images' => [UploadedFile::fake()->image('avatar.jpg')]
        ];

        $response = $this->postJson('api/v1/hotels', $hotel);
        $response->assertJsonPath('name', 'amir');
        $response->assertValid();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->where('name', 'amir')
                    ->where('emails.0.email', 'test11111@gmail.com')
                    ->etc()
            );
        $response->assertStatus(200);
    }
}
