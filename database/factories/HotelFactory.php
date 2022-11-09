<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Hotel::class;

    public function definition()
    {
        $title = fake()->title();
        return [
            'name' => fake()->name(),
            'title' => $title,
            'description' => fake()->text(),
            'slug' => Str::slug($title),
            'city_id'=> City::all()->random()->id,
        ];
    }
}
