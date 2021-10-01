<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APITest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_call()
    {
        $response = $this->postJson('api/bet', []);

        $response->assertStatus(200);
    }
}
