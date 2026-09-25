<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_contact_form_submission(): void
    {
        $payload = [
            'name' => 'ArtDevata',
            'email' => 'krama@artdevata.net',
            'phone' => '08123456789',
            'subject' => 'Permohonan Kolaborasi Ngayah',
            'message' => 'Om Swastyastu, kami ingin mengajak STT ArtDevata berkolaborasi dalam kegiatan kebersihan lingkungan banjar.',
        ];

        $response = $this->post('/kontak', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'krama@artdevata.net',
            'name' => 'ArtDevata',
        ]);
    }

    public function test_admin_can_create_activity(): void
    {
        $admin = User::where('role', 'superadmin')->first();
        $category = ActivityCategory::first();

        $payload = [
            'title' => 'Ngayah Massal Odalan Pura Banjar',
            'activity_category_id' => $category->id,
            'event_date' => now()->toDateString(),
            'location' => 'Pura Banjar ArtDevata',
            'description' => 'Kegiatan ngayah bersama seluruh pemuda adat.',
            'status' => 'published',
            'is_featured' => 1,
        ];

        $response = $this->actingAs($admin)->post('/admin/activities', $payload);
        $response->assertRedirect('/admin/activities');

        $this->assertDatabaseHas('activities', [
            'title' => 'Ngayah Massal Odalan Pura Banjar',
        ]);
    }

    public function test_admin_can_create_post(): void
    {
        $admin = User::where('role', 'superadmin')->first();
        $category = PostCategory::first();

        $payload = [
            'title' => 'Inovasi Ogoh-Ogoh Ramah Lingkungan 2026',
            'post_category_id' => $category->id,
            'summary' => 'STT ArtDevata menggunakan 100 persen bahan organik alami.',
            'content' => '<p>Artikel lengkap mengenai teknik pembuatan ogoh-ogoh ramah lingkungan tanpa styrofoam.</p>',
            'status' => 'published',
            'is_featured' => 1,
        ];

        $response = $this->actingAs($admin)->post('/admin/posts', $payload);
        $response->assertRedirect('/admin/posts');

        $this->assertDatabaseHas('posts', [
            'title' => 'Inovasi Ogoh-Ogoh Ramah Lingkungan 2026',
        ]);
    }

    public function test_admin_can_create_event(): void
    {
        $admin = User::where('role', 'superadmin')->first();

        $payload = [
            'title' => 'Paruman Rutin Purnama Kadasa',
            'event_date' => now()->addDays(5)->toDateString(),
            'start_time' => '19:00 WITA',
            'location' => 'Balai Banjar ArtDevata',
            'description' => 'Paruman evaluasi kerja triwulan.',
            'status' => 'upcoming',
        ];

        $response = $this->actingAs($admin)->post('/admin/events', $payload);
        $response->assertRedirect('/admin/events');

        $this->assertDatabaseHas('events', [
            'title' => 'Paruman Rutin Purnama Kadasa',
        ]);
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = User::where('role', 'superadmin')->first();

        $payload = [
            'site_name' => 'STT ArtDevata Updated',
            'banjar_name' => 'Banjar ArtDevata',
            'contact_address' => 'Jl. ArtDevata Baru No. 1',
            'contact_email' => 'info@artdevata.net',
            'contact_phone' => '+62 361 999999',
            'contact_whatsapp' => '628111222333',
        ];

        $response = $this->actingAs($admin)->post('/admin/settings', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'key' => 'site_name',
            'value' => 'STT ArtDevata Updated',
        ]);
    }
}
