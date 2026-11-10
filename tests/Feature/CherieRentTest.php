<?php

namespace Tests\Feature;

use App\Models\Dress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CherieRentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ChérieRent');
        $response->assertSee('Curated Gowns');
    }

    public function test_catalog_page_loads_with_dresses(): void
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
        $response->assertSee('Gown Collection Archive');
    }

    public function test_dress_detail_page_loads(): void
    {
        $dress = Dress::first();
        $response = $this->get('/catalog/'.$dress->slug);
        $response->assertStatus(200);
        $response->assertSee($dress->name);
    }

    public function test_customer_demo_login(): void
    {
        $response = $this->get('/demo-login/customer');
        $response->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    public function test_login_page_does_not_reveal_admin_demo_access(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertDontSee('Atelier Admin');
        $response->assertDontSee('Quick Demo Login Access');
    }

    public function test_admin_can_login_with_credentials_and_access_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'rentcherie@gmail.com',
            'password' => 'cece1329',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();

        $dashboard = $this->get('/admin/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Overview & Metrics');
    }

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $customer = User::where('role', 'customer')->first();
        $this->actingAs($customer);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_login_attempts_are_throttled_after_too_many_failures(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'attacker@cherierent.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'attacker@cherierent.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429);
    }

    public function test_admin_demo_login_and_access(): void
    {
        $response = $this->get('/demo-login/admin');
        $response->assertRedirect('/admin/dashboard');

        $this->assertAuthenticated();

        $adminDashboard = $this->get('/admin/dashboard');
        $adminDashboard->assertStatus(200);
        $adminDashboard->assertSee('Overview & Metrics');
    }
}
