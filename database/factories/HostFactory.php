<?php

namespace Database\Factories;

use App\Models\Host;
use App\Models\Hotel;
use Database\Seeders\Hosts\HostSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Host>
 */
class HostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Host::class;

    public function definition()
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'national_code' => fake()->numerify('#########'),
            'phone_number' => fake()->numerify('#########'),
            'email' => fake()->safeEmail(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Host $user) {
            //
        })->afterCreating(function (Host $host) {
        });
    }
}
