<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->name(),
            'user_id' => 1,
            'city_id'=> rand(1,1132),
        ];
    }
}
