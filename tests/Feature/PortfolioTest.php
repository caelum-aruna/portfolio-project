<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_projects_archive_page_can_be_rendered(): void
    {
        $response = $this->get('/projects');

        $response->assertStatus(200);
    }

    public function test_visitor_can_send_contact_message(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'New Project Inquiry',
            'message' => 'Hello Ikbal, I would like to build a web application.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_dashboard_and_view_stats(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/projects', [
            'title' => 'Sample Super App',
            'category' => 'Full Stack',
            'description' => 'A comprehensive test application',
            'tech_stack' => 'Laravel, Vue.js',
            'demo_url' => 'https://example.com',
            'is_featured' => true,
            'order' => 1,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', [
            'title' => 'Sample Super App',
        ]);
    }
}
