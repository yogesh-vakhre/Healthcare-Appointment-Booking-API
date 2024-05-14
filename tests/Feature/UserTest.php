<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_create_user()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password12',

        ];
        $response = $this->json('POST', '/api/v1/auth/register',$userData);
        $response->assertStatus(201); // Assert that the response has a 201 (Created) status code
     }
}

