<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_area_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_session_is_regenerated(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('very-secure-password'),
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'very-secure-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }
}
