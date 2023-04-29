<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


use App\Models\User;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = User::factory()->create();

        $response = $this->PostJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function testUserCanLoginWithInCorrectCredentials()
    {
        $user = User::factory()->create();

        $response = $this->PostJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(422);
    }



    public function testUserCanRegisterWithCorrectCredentials()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);
     
        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
            ]);
     
        $this->assertDatabaseHas('users', [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function testUserCanRegisterWithInCorrectCredentials()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'wrong_password',
        ]);
     
        $response->assertStatus(422);

     
        $this->assertDatabaseMissing('users', [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }



}
