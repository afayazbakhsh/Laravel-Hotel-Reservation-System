<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function test_api_register_user_successful()
    {

        $this->seed(PermissionSeeder::class);

        $response = $this->postJson('api/v1/auth/register', [
            'email' => 'test@gmail.com',
            'password' => 'amir?is',
            'password_confirmation' => 'amir?is'
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>

            $json
                ->has('user')
                ->has('access_token')
        );
    }

    public function test_api_register_email_is_empty_return_error()
    {

        $this->seed(PermissionSeeder::class);

        $response = $this->postJson('api/v1/auth/register', [
            'email' => '',
            'password' => 'amir?is',
            'password_confirmation' => 'amir?is'
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>

            $json
                ->where('success',false)
                ->where('message','Validation errors')
                ->where('data.email.0','تمامی فیلد هارا پر کنید')
        );
    }

    public function test_api_register_with_email_invalid_return_error()
    {

        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();

        $response = $this->postJson('api/v1/auth/register', [
            'email' => $user->email,
            'password' => 'amir?is',
            'password_confirmation' => 'amir?is'
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>

            $json
                ->where('success',false)
                ->where('message','Validation errors')
                ->where('data.email.0','این ایمیل قبلا استفاده شده است')
        );
    }

    public function test_api_register_with_weak_password_return_error()
    {

        $this->seed(PermissionSeeder::class);

        $response = $this->postJson('api/v1/auth/register', [
            'email' => 'test@gmail.com',
            'password' => 'ami',
            'password_confirmation' => 'ami'
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>

            $json
                ->where('success',false)
                ->where('message','Validation errors')
                ->where('data.password.0','پسورد کوتاه و ضعیف است')
        );
    }

    public function test_api_register_password_not_match_return_error()
    {

        $this->seed(PermissionSeeder::class);

        $response = $this->postJson('api/v1/auth/register', [
            'email' => 'test@gmail.com',
            'password' => 'amir?is',
            'password_confirmation' => 'test1'
        ]);

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>

            $json
                ->where('success',false)
                ->where('message','Validation errors')
                ->where('data.password.0','پسوردهای وارد شده یکسان نیستند')
        );
    }
}
