<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_return_successful_response(): void
    {
        $routes = [
            '/',
            '/tentang',
            '/struktur',
            '/pengurus',
            '/kegiatan',
            '/agenda',
            '/galeri',
            '/berita',
            '/program-kerja',
            '/dokumen',
            '/kontak',
            '/login',
            '/robots.txt',
            '/sitemap.xml',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_admin_dashboard_accessible_by_authenticated_admin(): void
    {
        $admin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);

        $adminRoutes = [
            '/admin/posts',
            '/admin/activities',
            '/admin/events',
            '/admin/gallery',
            '/admin/work-programs',
            '/admin/members',
            '/admin/documents',
            '/admin/pages',
            '/admin/homepage',
            '/admin/settings',
            '/admin/media',
            '/admin/messages',
            '/admin/users',
            '/admin/activity-logs',
            '/admin/profile',
        ];

        foreach ($adminRoutes as $route) {
            $resp = $this->actingAs($admin)->get($route);
            $resp->assertStatus(200);
        }
    }
}
