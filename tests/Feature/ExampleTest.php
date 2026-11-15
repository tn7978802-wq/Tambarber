<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_homepage_redirects_to_login_for_guests(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_the_login_page_renders(): void
    {
        $this->get('/dang-nhap')->assertOk();
    }
}
