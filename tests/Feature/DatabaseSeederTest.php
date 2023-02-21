<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_can_created(){
        $this->seed();
        $this->assertDatabaseCount('hosts', 5);
        $this->assertDatabaseCount('hotels', 15);
    }
}
