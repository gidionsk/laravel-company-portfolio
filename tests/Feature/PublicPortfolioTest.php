<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_and_project_listing_are_available(): void
    {
        $this->seed();

        $this->get('/')->assertOk();
        $this->get('/projects')->assertOk();
        $this->get('/health')->assertOk()->assertJson(['status' => 'ok']);
        $this->get('/sitemap.xml')->assertOk();
    }

    public function test_unpublished_project_is_not_publicly_visible(): void
    {
        $project = Project::create([
            'title' => 'Private Draft',
            'slug' => 'private-draft',
            'summary' => 'Draft project',
            'theme' => 'indigo',
            'is_published' => false,
        ]);

        $this->get(route('projects.show', $project))->assertNotFound();
    }

    public function test_contact_form_accepts_valid_message_and_rejects_honeypot(): void
    {
        $payload = [
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'company' => 'Demo Co',
            'phone' => '+628123456789',
            'budget' => 'Rp25–50 juta',
            'message' => 'Saya ingin mendiskusikan project demo.',
        ];

        $this->post('/contact', $payload)->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', ['email' => 'demo@example.com']);

        $this->post('/contact', $payload + ['website' => 'https://spam.example'])
            ->assertSessionHasErrors('website');
    }
}
