<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    /** @test */
    public function home_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
} 