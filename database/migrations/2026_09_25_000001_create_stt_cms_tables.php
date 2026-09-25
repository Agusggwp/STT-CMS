<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users additional columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('pengurus')->after('password');
            $table->string('avatar')->nullable()->after('role');
            $table->string('phone')->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('phone');
            $table->string('status')->default('active')->after('bio');
        });

        // 2. Site Settings
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index();
            $table->longText('value')->nullable();
            $table->string('group')->default('general')->index();
            $table->string('type')->default('text');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // 3. Pages
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status')->default('published')->index();
            $table->integer('order')->default(0);
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });

        // 4. Page Sections (Page Builder)
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->cascadeOnDelete();
            $table->string('page_key')->default('home')->index();
            $table->string('section_key')->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('type')->default('text'); // text, image, text_image, gallery, event, news, cta, faq, statistics, custom
            $table->json('data')->nullable();
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        // 5. Post Categories
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 6. Posts (Berita)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('post_categories')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('thumbnail')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('author_name')->nullable();
            $table->string('status')->default('published')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamp('published_at')->nullable()->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 7. Activity Categories
        Schema::create('activity_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 8. Activities (Kegiatan)
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('activity_categories')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->date('event_date')->nullable()->index();
            $table->string('location')->nullable();
            $table->string('author_name')->nullable();
            $table->string('status')->default('published')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->json('gallery_images')->nullable();
            $table->timestamps();
        });

        // 9. Events (Agenda)
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->date('event_date')->index();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('location');
            $table->string('poster')->nullable();
            $table->string('registration_link')->nullable();
            $table->string('status')->default('upcoming')->index(); // upcoming, ongoing, completed, cancelled
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamps();
        });

        // 10. Gallery Albums
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('event_date')->nullable();
            $table->string('category')->default('Budaya')->index();
            $table->integer('order')->default(0)->index();
            $table->string('status')->default('published')->index();
            $table->timestamps();
        });

        // 11. Gallery Images
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('gallery_albums')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0)->index();
            $table->timestamps();
        });

        // 12. Organizational Positions
        Schema::create('organizational_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->integer('level')->default(1)->index();
            $table->integer('order')->default(0)->index();
            $table->timestamps();
        });

        // 13. Members (Pengurus & Struktur)
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->nullable()->constrained('organizational_positions')->nullOnDelete();
            $table->string('name');
            $table->string('position_title');
            $table->string('period')->default('2024 - 2027');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        // 14. Work Programs (Program Kerja)
        Schema::create('work_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->text('objectives')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('status')->default('rencana')->index(); // rencana, berjalan, selesai
            $table->text('documentation_notes')->nullable();
            $table->timestamps();
        });

        // 15. Documents (Dokumen Organisasi)
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('category')->default('Dokumen Organisasi')->index();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->unsignedInteger('downloads_count')->default(0);
            $table->date('published_at')->nullable();
            $table->timestamps();
        });

        // 16. Media Library
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('mime_type');
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->string('folder')->default('uploads')->index();
            $table->timestamps();
        });

        // 17. Contact Messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->boolean('is_read')->default(false)->index();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });

        // 18. Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('subject_type')->nullable()->index();
            $table->unsignedBigInteger('subject_id')->nullable()->index();
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('media');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('work_programs');
        Schema::dropIfExists('members');
        Schema::dropIfExists('organizational_positions');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('gallery_albums');
        Schema::dropIfExists('events');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('activity_categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('site_settings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'phone', 'bio', 'status']);
        });
    }
};
