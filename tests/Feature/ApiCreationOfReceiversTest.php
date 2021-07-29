<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCreationOfReceiversTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_a_receiver_with_all_respective_relative_tables()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
