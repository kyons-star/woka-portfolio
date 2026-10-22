<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('/build/assets/app-');
        $response->assertSee('sample-avatar.jpg');

        self::assertFileExists(public_path('images/hero.jpg'));
        self::assertFileExists(public_path('images/auth-bg.jpg'));
        self::assertFileExists(public_path('images/sample-avatar.jpg'));
    }
}
