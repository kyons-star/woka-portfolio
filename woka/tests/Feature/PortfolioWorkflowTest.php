<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_and_open_the_dashboard(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Portfolio Owner',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('name_key', 'portfolio owner')->firstOrFail();

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk();
    }

    public function test_an_existing_user_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.store'), [
            'name' => $user->name,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_an_owner_can_create_update_change_style_and_delete_a_portfolio(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('portfolios.store'), ['style' => 'Simple']);
        $portfolio = $user->portfolios()->firstOrFail();

        $response->assertRedirect(route('portfolios.edit', $portfolio));

        $this->put(route('portfolios.update', $portfolio), [
            'name' => 'Updated Name',
            'email' => 'owner@example.com',
            'edu' => [['school' => 'Example University', 'degree' => 'Engineering', 'years' => '2020-2024']],
        ])->assertRedirect(route('portfolios.show', $portfolio));

        $this->assertSame('Updated Name', $portfolio->fresh()->data['name']);
        $this->assertSame('Example University', $portfolio->fresh()->data['edu'][0]['school']);

        $this->patch(route('portfolios.style', $portfolio), ['style' => 'Modern'])
            ->assertRedirect(route('portfolios.show', $portfolio));
        $this->assertSame('Modern', $portfolio->fresh()->style);

        $this->get(route('portfolios.show', $portfolio))
            ->assertOk()
            ->assertSee('Updated Name');

        $this->delete(route('portfolios.destroy', $portfolio))
            ->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }

    public function test_a_user_cannot_view_or_delete_another_users_portfolio(): void
    {
        $owner = User::factory()->create();
        $portfolio = $owner->portfolios()->create([
            'number' => 1,
            'style' => 'Simple',
            'data' => ['name' => 'Private Portfolio'],
        ]);

        $this->actingAs(User::factory()->create());

        $this->get(route('portfolios.show', $portfolio))->assertNotFound();
        $this->delete(route('portfolios.destroy', $portfolio))->assertNotFound();

        $this->assertDatabaseHas('portfolios', ['id' => $portfolio->id]);
    }
}
