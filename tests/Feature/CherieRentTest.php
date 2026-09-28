<?php

namespace Tests\Feature;

use App\Models\Dress;
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
