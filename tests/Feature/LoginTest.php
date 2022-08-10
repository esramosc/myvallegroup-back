<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * User can login with valid credentials.
     *
     * @return void
     */
    public function test_a_user_can_login_with_credentials()
    {
        $response = $this->postJson(
            route('login'),
            [
                'email' => 'abner.morales.2022@gmail.com',
                'password' => 'myvallegroup'
            ]
        )->assertOk();

        $this->assertArrayHasKey('access_token', $response->json());
    }

    /**
     * User cannot login with invalid credentials.
     *
     * @return void
     */
    public function test_a_user_cannot_login_with_bad_credentials()
    {
        $response = $this->postJson(
            route('login'),
            [
                'email' => 'esramosc@gmail.com',
                'password' => 'mypassword'
            ]
        )->assertStatus(500);
        $this->assertArrayHasKey('error', $response->json());
    }
}
