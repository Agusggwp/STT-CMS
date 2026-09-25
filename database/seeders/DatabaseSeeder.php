<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\ContactMessage;
use App\Models\Document;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\Member;
use App\Models\OrganizationalPosition;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\WorkProgram;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $pengurusRole = Role::firstOrCreate(['name' => 'pengurus']);

        $permissions = [
            'manage-content',
            'manage-users',
            'manage-settings',
            'manage-gallery',
            'manage-activities',
            'manage-events',
            'manage-documents',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $superAdminRole->syncPermissions(Permission::all());
        $editorRole->syncPermissions(['manage-content', 'manage-gallery', 'manage-activities', 'manage-events', 'manage-documents']);
        $pengurusRole->syncPermissions(['manage-gallery', 'manage-activities', 'manage-events']);

        // 2. Default Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@sttbali.id'],
            [
                'name' => 'ArtDevata',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'phone' => '+62 812-3456-7890',
                'bio' => 'Administrator Utama STT Bali dari ArtDevata. Mengabdi untuk pelestarian tradisi dan kemajuan pemuda Banjar.',
                'status' => 'active',
            ]
        );
        $admin->syncRoles([$superAdminRole]);

        $editor = User::updateOrCreate(
            ['email' => 'sekretaris@sttbali.id'],
            [
                'name' => 'ArtDevata',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'phone' => '+62 813-9876-5432',
                'bio' => 'Editor & Tim Dokumentasi STT Bali dari ArtDevata. Aktif mengelola arsip, komunikasi digital, dan kegiatan pemudi.',
                'status' => 'active',
            ]
        );
        $editor->syncRoles([$editorRole]);

        // 3. Site Settings
        $settings = [
            // General
            ['key' => 'org_name', 'value' => 'Sekaa Teruna Teruni ArtDevata', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Organisasi'],
            ['key' => 'org_short_name', 'value' => 'STT ArtDevata', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Pendek'],
            ['key' => 'banjar_name', 'value' => 'Banjar ArtDevata', 'group' => 'general', 'type' => 'text', 'label' => 'Nama Banjar'],
            ['key' => 'desa_adat', 'value' => 'Desa Adat ArtDevata', 'group' => 'general', 'type' => 'text', 'label' => 'Desa Adat'],
            ['key' => 'tagline', 'value' => 'Generasi Muda ArtDevata, Berkarya untuk Banjar dan Budaya', 'group' => 'general', 'type' => 'text', 'label' => 'Tagline Utama'],
            ['key' => 'description', 'value' => 'Sekaa Teruna Teruni ArtDevata adalah wadah kepemudaan adat di lingkungan Banjar ArtDevata yang berlandaskan kearifan lokal Tri Hita Karana, menjunjung tinggi nilai ngayah, gotong royong, dan pelestarian seni budaya Bali.', 'group' => 'general', 'type' => 'textarea', 'label' => 'Deskripsi Organisasi'],

            // Contact
            ['key' => 'phone', 'value' => '+62 812-3456-7890', 'group' => 'contact', 'type' => 'text', 'label' => 'Nomor Telepon'],
            ['key' => 'whatsapp', 'value' => '6281234567890', 'group' => 'contact', 'type' => 'text', 'label' => 'Nomor WhatsApp'],
            ['key' => 'email', 'value' => 'kontak@artdevata.net', 'group' => 'contact', 'type' => 'email', 'label' => 'Email Resmi'],
            ['key' => 'address', 'value' => 'Balai Banjar ArtDevata, Jl. ArtDevata No. 1, Denpasar, Bali 80223', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Alamat Banjar'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15777.728956961448!2d115.2155822!3d-8.6853245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd240c1e878bd6f%3A0x6335198df589b37c!2sDenpasar%20City%2C%20Bali!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Embed Google Maps'],

            // Social
            ['key' => 'instagram', 'value' => 'https://instagram.com/artdevata', 'group' => 'social', 'type' => 'text', 'label' => 'Instagram'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/artdevata', 'group' => 'social', 'type' => 'text', 'label' => 'Facebook'],
            ['key' => 'tiktok', 'value' => 'https://tiktok.com/@artdevata', 'group' => 'social', 'type' => 'text', 'label' => 'TikTok'],
            ['key' => 'youtube', 'value' => 'https://youtube.com/@artdevata', 'group' => 'social', 'type' => 'text', 'label' => 'YouTube'],

            // Hero CMS
            ['key' => 'hero_badge', 'value' => 'Sekaa Teruna Teruni • Banjar ArtDevata', 'group' => 'hero', 'type' => 'text', 'label' => 'Hero Badge Text'],
            ['key' => 'hero_title_prefix', 'value' => 'SEKAA TERUNA TERUNI', 'group' => 'hero', 'type' => 'text', 'label' => 'Hero Title Prefix'],
            ['key' => 'hero_headline', 'value' => 'Generasi Muda ArtDevata, Berkarya untuk Banjar dan Budaya', 'group' => 'hero', 'type' => 'text', 'label' => 'Hero Headline Utama'],
            ['key' => 'hero_description', 'value' => 'Wadah kebersamaan pemuda adat dalam merawat keluhuran tradisi, ngayah tulus ikhlas, dan menyalakan api kreativitas generasi muda tanpa kehilangan jati diri kearifan lokal Bali.', 'group' => 'hero', 'type' => 'textarea', 'label' => 'Hero Deskripsi Singkat'],
            ['key' => 'hero_cta_primary_text', 'value' => 'Lihat Kegiatan', 'group' => 'hero', 'type' => 'text', 'label' => 'CTA Utama Text'],
            ['key' => 'hero_cta_primary_url', 'value' => '/kegiatan', 'group' => 'hero', 'type' => 'text', 'label' => 'CTA Utama Link'],
            ['key' => 'hero_cta_secondary_text', 'value' => 'Kenali STT', 'group' => 'hero', 'type' => 'text', 'label' => 'CTA Kedua Text'],
            ['key' => 'hero_cta_secondary_url', 'value' => '/tentang', 'group' => 'hero', 'type' => 'text', 'label' => 'CTA Kedua Link'],
            ['key' => 'hero_image', 'value' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85', 'group' => 'hero', 'type' => 'image', 'label' => 'Hero Image Foto Nyata'],

            // Footer
            ['key' => 'footer_about', 'value' => 'Platform resmi Sekaa Teruna Teruni Banjar ArtDevata sebagai pusat informasi, transparansi program, dan etalase karya pemuda adat Bali modern.', 'group' => 'footer', 'type' => 'textarea', 'label' => 'Deskripsi Singkat Footer'],
            ['key' => 'footer_copyright', 'value' => '© 2026 STT ArtDevata Banjar ArtDevata. Seluruh Hak Cipta Dilindungi.', 'group' => 'footer', 'type' => 'text', 'label' => 'Copyright Text'],
            ['key' => 'footer_dev_credit', 'value' => 'Website dikembangkan oleh ArtDevata', 'group' => 'footer', 'type' => 'text', 'label' => 'Developer Credit Text'],
            ['key' => 'footer_dev_url', 'value' => 'https://artdevata.net', 'group' => 'footer', 'type' => 'text', 'label' => 'Developer Credit URL'],

            // SEO Global
            ['key' => 'meta_title', 'value' => 'STT ArtDevata — Sekaa Teruna Teruni Banjar ArtDevata Bali', 'group' => 'seo', 'type' => 'text', 'label' => 'Default SEO Title'],
            ['key' => 'meta_description', 'value' => 'Situs resmi Sekaa Teruna Teruni (STT) ArtDevata Banjar ArtDevata Bali. Informasi kegiatan adat, pemuda banjar, karya budaya, dan agenda kepemudaan Bali.', 'group' => 'seo', 'type' => 'textarea', 'label' => 'Default Meta Description'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // 4. Post Categories & Posts
        $postCategories = [
            ['name' => 'Kegiatan Banjar', 'slug' => 'kegiatan-banjar', 'description' => 'Aktivitas seputar banjar dan lingkungan krama adat.'],
            ['name' => 'Seni & Budaya', 'slug' => 'seni-dan-budaya', 'description' => 'Pelestarian gamelan, tari, ogoh-ogoh, dan sastra Bali.'],
            ['name' => 'Kegiatan Sosial', 'slug' => 'kegiatan-sosial', 'description' => 'Bakti sosial, gotong royong, dan aksi kemanusiaan.'],
            ['name' => 'Rapat & Organisasi', 'slug' => 'rapat-organisasi', 'description' => 'Paruman, musyawarah, dan koordinasi kepengurusan.'],
        ];

        $catModels = [];
        foreach ($postCategories as $pc) {
            $catModels[$pc['slug']] = PostCategory::updateOrCreate(['slug' => $pc['slug']], $pc);
        }

        $posts = [
            [
                'category_id' => $catModels['kegiatan-sosial']->id,
                'user_id' => $admin->id,
                'title' => 'STT ArtDevata Selenggarakan Gotong Royong Massal dan Resik Sampah di Lingkungan Banjar',
                'slug' => 'stt-artdevata-selenggarakan-gotong-royong-massal-resik-sampah',
                'thumbnail' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Puluhan pemuda dan pemudi bergotong royong membersihkan saluran drainase dan memilah sampah plastik di seluruh wilayah Banjar ArtDevata.',
                'content' => "<p>Menjaga kebersihan dan keharmonisan lingkungan (Palemahan) merupakan salah satu wujud nyata ajaran Tri Hita Karana yang senantiasa dihidupkan oleh krama muda STT ArtDevata.</p><p>Pada hari Minggu pagi, puluhan pemuda dan pemudi STT berkumpul di Balai Banjar ArtDevata sejak pukul 06.30 WITA dengan mengenakan pakaian adat madya dan perlengkapan kebersihan. Kegiatan difokuskan pada pembersihan saluran air, pemilahan sampah organik dan anorganik berbasis sumber, serta penataan tanaman perindang di sepanjang jalan utama banjar.</p><p>Pengurus STT ArtDevata bersama Tim ArtDevata menyampaikan bahwa aksi resik lingkungan ini merupakan agenda rutin bulanan yang tidak hanya bertujuan menjaga estetika desa, namun juga memupuk rasa memiliki dan ikatan persaudaraan (menyama braya) antar generasi muda.</p>",
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => true,
                'views_count' => 342,
                'published_at' => Carbon::now()->subDays(3),
                'meta_title' => 'Gotong Royong Massal STT ArtDevata Banjar ArtDevata',
                'meta_description' => 'Dokumentasi kegiatan gotong royong pemuda STT ArtDevata membersihkan lingkungan Banjar ArtDevata Bali.',
            ],
            [
                'category_id' => $catModels['seni-dan-budaya']->id,
                'user_id' => $admin->id,
                'title' => 'Karya Ogoh-Ogoh Ramah Lingkungan STT ArtDevata Masuk Nominasi Terbaik Kota',
                'slug' => 'karya-ogoh-ogoh-ramah-lingkungan-masuk-nominasi-terbaik',
                'thumbnail' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Menggunakan 100% anyaman bambu, enceng gondok, dan kertas daur ulang tanpa styrofoam, karya seni pemuda mendapat apresiasi tinggi dewan juri.',
                'content' => "<p>Konsistensi STT ArtDevata dalam mempertahankan prinsip ramah lingkungan pada pembuatan karya ogoh-ogoh membuahkan hasil membanggakan. Pada penilaian tahun ini, ogoh-ogoh bertajuk 'Kala Rau' resmi masuk dalam jajaran nominasi terbaik tingkat Kota Denpasar.</p><p>Seluruh struktur ogoh-ogoh dikerjakan secara gotong royong oleh para pemuda selama hampir dua bulan penuh di Balai Banjar ArtDevata. Setiap malam, para arsitek muda, perajin anyaman bambu, dan pemuda banjar saling bertukar ide teknik anatomi gerak serta pewarnaan alami berbahan dasar tanah liat dan abu arang.</p><p>'Kami ingin membuktikan bahwa estetika mahakarya budaya Bali justru semakin berkilau ketika dibuat dengan material alamiah yang tidak mencemari bumi,' ujar perwakilan Tim ArtDevata.</p>",
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => true,
                'views_count' => 589,
                'published_at' => Carbon::now()->subDays(7),
                'meta_title' => 'Karya Ogoh-Ogoh Ramah Lingkungan STT ArtDevata',
                'meta_description' => 'Prestasi ogoh-ogoh ramah lingkungan buatan krama teruna Banjar ArtDevata berhasil masuk nominasi kota.',
            ],
            [
                'category_id' => $catModels['kegiatan-banjar']->id,
                'user_id' => $editor->id,
                'title' => 'Semangat Ngayah Megambel dan Menari Rejang Menjelang Piodalan di Pura Kahyangan',
                'slug' => 'semangat-ngayah-megambel-dan-menari-rejang-menjelang-piodalan',
                'thumbnail' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Teruna dan teruni tekun mempersiapkan persembahan tabuh gong kebyar dan tarian rejang suci untuk rangkaian upacara yadnya.',
                'content' => "<p>Menjelang pujawali di Pura Kahyangan, alunan suara gambelan gong kebyar menggema setiap sore di pelataran balai banjar. Krama teruna (pemuda) berlatih gending tabuh lelambatan dan bebarongan, sementara krama teruni (pemudi) mematangkan gerakan tari Rejang Sandat yang akan ditarikan saat puncak karya.</p><p>Tradisi ngayah ini menjadi sarana transfer pengetahuan adat dari para tetua banjar kepada generasi muda, menjaga kesinambungan seni sakral agar tetap lestari dan penuh taksu.</p>",
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => false,
                'views_count' => 210,
                'published_at' => Carbon::now()->subDays(12),
                'meta_title' => 'Ngayah Megambel dan Rejang STT ArtDevata',
                'meta_description' => 'Persiapan ngayah pemuda pemudi STT ArtDevata menyongsong piodalan agung banjar.',
            ],
            [
                'category_id' => $catModels['rapat-organisasi']->id,
                'user_id' => $admin->id,
                'title' => 'Paruman Rutin Bulanan: Penetapan Jadwal Program Kerja Caturwulan',
                'slug' => 'paruman-rutin-bulanan-penetapan-jadwal-program-kerja-caturwulan',
                'thumbnail' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Musyawarah mufakat seluruh anggota STT menetapkan skala prioritas kegiatan kepemudaan, sosial, dan pelatihan kewirausahaan kreatif.',
                'content' => "<p>Paruman bulanan dihadiri oleh lebih dari 90 anggota aktif bersama prajuru banjar dan tetua adat. Forum berjalan dinamis dengan mengedepankan asas musyawarah mufakat khas desa adat Bali.</p><p>Beberapa agenda utama yang disepakati mencakup revitalisasi bank sampah pemuda, pengadaan seragam adat madya baru, serta pembentukan panitia pekan olahraga dan kreativitas seni remaja tahun 2026.</p>",
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => false,
                'views_count' => 148,
                'published_at' => Carbon::now()->subDays(18),
                'meta_title' => 'Paruman Bulanan Krama Teruna Banjar ArtDevata',
                'meta_description' => 'Hasil musyawarah paruman rutin STT ArtDevata periode caturwulan.',
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 5. Activity Categories & Activities
        $actCategories = [
            ['name' => 'Gotong Royong', 'slug' => 'gotong-royong', 'description' => 'Aksi kerja bakti pembersihan dan perawatan banjar.'],
            ['name' => 'Kegiatan Banjar', 'slug' => 'kegiatan-banjar', 'description' => 'Dukungan penuh pemuda pada setiap upacara dan agenda banjar.'],
            ['name' => 'Budaya & Seni', 'slug' => 'budaya-dan-seni', 'description' => 'Latihan tari, megambel, aksara Bali, dan karya ogoh-ogoh.'],
            ['name' => 'Sosial & Kemanusiaan', 'slug' => 'sosial-kemanusiaan', 'description' => 'Aksi peduli lansia, donor darah, dan bantuan kemanusiaan.'],
            ['name' => 'Olahraga & Pemuda', 'slug' => 'olahraga-pemuda', 'description' => 'Turnamen voli, bulutangkis, jalan sehat, dan keakraban.'],
        ];

        $actCatModels = [];
        foreach ($actCategories as $ac) {
            $actCatModels[$ac['slug']] = ActivityCategory::updateOrCreate(['slug' => $ac['slug']], $ac);
        }

        $activities = [
            [
                'category_id' => $actCatModels['gotong-royong']->id,
                'user_id' => $admin->id,
                'title' => 'Aksi Resik Sampah dan Penataan Lingkungan Banjar ArtDevata',
                'slug' => 'aksi-resik-sampah-dan-penataan-lingkungan-banjar',
                'thumbnail' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Kerja bakti bersama seluruh anggota pemuda memilah sampah organik dan non-organik di wewidangan banjar.',
                'content' => '<p>Kegiatan gotong royong rutin yang melibatkan seluruh krama teruna dan teruni Banjar ArtDevata. Meliputi pembersihan selokan, pengecatan dinding balai banjar, dan penyortiran botol plastik untuk didistribusikan ke bank sampah banjar.</p>',
                'event_date' => Carbon::now()->subDays(5),
                'location' => 'Wewidangan Banjar ArtDevata, Bali',
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => true,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1000&q=80',
                ],
            ],
            [
                'category_id' => $actCatModels['budaya-dan-seni']->id,
                'user_id' => $admin->id,
                'title' => 'Pembuatan Ogoh-Ogoh Ramah Lingkungan Caka 1948',
                'slug' => 'pembuatan-ogoh-ogoh-ramah-lingkungan-caka-1948',
                'thumbnail' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Proses kreatif pembuatan ogoh-ogoh berbahan alami bambu, enceng gondok, dan kertas tanpa menggunakan styrofoam.',
                'content' => '<p>Tradisi tahunan yang menjadi ruang kreasi teruna teruni dalam memadukan keahlian teknik pahat, struktur rangka bambu dinamis, serta filosofi mitologi Hindu Bali. Seluruh tahapan dikerjakan secara swadaya di Balai Banjar ArtDevata.</p>',
                'event_date' => Carbon::now()->subDays(14),
                'location' => 'Balai Banjar ArtDevata',
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => true,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1000&q=80',
                ],
            ],
            [
                'category_id' => $actCatModels['kegiatan-banjar']->id,
                'user_id' => $editor->id,
                'title' => 'Ngayah Tabuh Gong Kebyar dan Pesanti Menjelang Piodalan',
                'slug' => 'ngayah-tabuh-gong-kebyar-dan-pesanti-menjelang-piodalan',
                'thumbnail' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Latihan rutin dan persembahan ngayah tabuh gamelan Bali menyambut upacara piodalan agung pura.',
                'content' => '<p>Wadah pembinaan generasi muda dalam memainkan instrumen gamelan tradisional Bali seperti ugal, kantil, gong, kendang, dan ceng-ceng di bawah asuhan pelatih karawitan banjar.</p>',
                'event_date' => Carbon::now()->subDays(20),
                'location' => 'Pura Kahyangan Tiga Banjar ArtDevata',
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => true,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1000&q=80',
                ],
            ],
            [
                'category_id' => $actCatModels['sosial-kemanusiaan']->id,
                'user_id' => $editor->id,
                'title' => 'Aksi Donor Darah Peduli Kemanusiaan Pemuda Banjar',
                'slug' => 'aksi-donor-darah-peduli-kemanusiaan-pemuda-banjar',
                'thumbnail' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Bekerja sama dengan PMI Kota Denpasar mengumpulkan 75 kantong darah dari warga dan pemuda banjar.',
                'content' => '<p>Wujud kepedulian sosial kemasyarakatan STT ArtDevata untuk membantu pemenuhan stok darah rumah sakit sekaligus mengedukasi generasi muda tentang pentingnya gaya hidup sehat dan berbagi kebaikan.</p>',
                'event_date' => Carbon::now()->subDays(30),
                'location' => 'Wantilan Balai Banjar ArtDevata',
                'author_name' => 'Tim ArtDevata',
                'status' => 'published',
                'is_featured' => false,
                'gallery_images' => [],
            ],
        ];

        foreach ($activities as $act) {
            Activity::updateOrCreate(['slug' => $act['slug']], $act);
        }

        // 6. Events (Agenda)
        $events = [
            [
                'title' => 'Paruman Agung dan Evaluasi Program Caturwulan',
                'slug' => 'paruman-agung-evaluasi-program-caturwulan',
                'description' => 'Pertemuan akbar seluruh anggota pemuda pemudi bersama Prajuru Banjar ArtDevata untuk mengevaluasi program kerja serta menyusun anggaran kegiatan tahunan.',
                'event_date' => Carbon::now()->addDays(5),
                'start_time' => '19:00',
                'end_time' => '22:00 WITA',
                'location' => 'Balai Banjar ArtDevata, Bali',
                'poster' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1000&q=80',
                'registration_link' => 'https://wa.me/6281234567890?text=Konfirmasi%20Kehadiran%20Paruman',
                'status' => 'upcoming',
                'is_featured' => true,
            ],
            [
                'title' => 'Latihan Rutin Karawitan Gong Kebyar & Tari Rejang',
                'slug' => 'latihan-rutin-karawitan-gong-kebyar-tari-rejang',
                'description' => 'Latihan terpadu gamelan tabuh bebarongan oleh teruna dan pengasahan tari Rejang Sandat oleh teruni sebagai persiapan karya piodalan.',
                'event_date' => Carbon::now()->addDays(12),
                'start_time' => '16:30',
                'end_time' => '19:00 WITA',
                'location' => 'Wantilan Pura Dalem ArtDevata',
                'poster' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1000&q=80',
                'registration_link' => null,
                'status' => 'upcoming',
                'is_featured' => true,
            ],
            [
                'title' => 'Ngayah Massal Persiapan Rahina Tumpek Krulut',
                'slug' => 'ngayah-massal-persiapan-rahina-tumpek-krulut',
                'description' => 'Kegiatan ngayah merawat gamelan banjar, membersihkan wantilan, dan merangkai penjor kasih sayang menyambut hari suci pemuliaan seni.',
                'event_date' => Carbon::now()->addDays(20),
                'start_time' => '07:00',
                'end_time' => '12:00 WITA',
                'location' => 'Balai Banjar ArtDevata',
                'poster' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80',
                'registration_link' => null,
                'status' => 'upcoming',
                'is_featured' => false,
            ],
            // Past Events
            [
                'title' => 'Parade Ogoh-Ogoh Malam Pangerupukan Caka 1947',
                'slug' => 'parade-ogoh-ogoh-malam-pangerupukan-caka-1947',
                'description' => 'Pementasan atraksi seni ogoh-ogoh mengelilingi catus pata Banjar ArtDevata yang diiringi tabuh bleganjur pemuda STT.',
                'event_date' => Carbon::now()->subMonths(3),
                'start_time' => '19:30',
                'end_time' => '23:30 WITA',
                'location' => 'Catus Pata ArtDevata',
                'poster' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1000&q=80',
                'registration_link' => null,
                'status' => 'completed',
                'is_featured' => false,
            ],
            [
                'title' => 'Turnamen Futsal dan Voli Antar Pemuda Banjar',
                'slug' => 'turnamen-futsal-dan-voli-antar-pemuda-banjar',
                'description' => 'Ajang olahraga persahabatan untuk memupuk kekompakan fisik dan sportivitas krama teruna Banjar ArtDevata.',
                'event_date' => Carbon::now()->subMonths(5),
                'start_time' => '15:00',
                'end_time' => '18:00 WITA',
                'location' => 'Lapangan Olahraga ArtDevata',
                'poster' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80',
                'registration_link' => null,
                'status' => 'completed',
                'is_featured' => false,
            ],
        ];

        foreach ($events as $ev) {
            Event::updateOrCreate(['slug' => $ev['slug']], $ev);
        }

        // 7. Gallery Albums & Images
        $albums = [
            [
                'title' => 'Malam Pangerupukan & Mahakarya Ogoh-Ogoh Caka 1947',
                'slug' => 'malam-pangerupukan-ogoh-ogoh-caka-1947',
                'description' => 'Dokumentasi lengkap proses perakitan, pementasan bleganjur, dan pawai ogoh-ogoh pemuda Banjar ArtDevata.',
                'cover_image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80',
                'event_date' => Carbon::now()->subMonths(3),
                'category' => 'Budaya',
                'order' => 1,
                'status' => 'published',
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Rangkaian ogoh-ogoh ramah lingkungan saat melintasi catus pata', 'order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Penabuh bleganjur STT menyemangati arak-arakan pemuda', 'order' => 2],
                    ['image_path' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Solidaritas pemuda mengusung ogoh-ogoh dengan formasi berputar', 'order' => 3],
                ],
            ],
            [
                'title' => 'Aksi Ngayah Piodalan di Pura Kahyangan Tiga',
                'slug' => 'aksi-ngayah-piodalan-pura-kahyangan-tiga',
                'description' => 'Dokumentasi persembahan tulus pemuda pemudi menabuh gamelan, merangkai penjor, dan ngayah piodalan.',
                'cover_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                'event_date' => Carbon::now()->subDays(20),
                'category' => 'Odalan',
                'order' => 2,
                'status' => 'published',
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Pementasan tabuh lelambatan di jaba tengah pura', 'order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Krama teruni menarikan Rejang Dewa dengan khidmat', 'order' => 2],
                ],
            ],
            [
                'title' => 'Gotong Royong & Pilah Sampah Mandiri Banjar',
                'slug' => 'gotong-royong-pilah-sampah-mandiri-banjar',
                'description' => 'Aksi nyata pelestarian palemahan lingkungan banjar bersama seluruh krama pemuda.',
                'cover_image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80',
                'event_date' => Carbon::now()->subDays(5),
                'category' => 'Gotong Royong',
                'order' => 3,
                'status' => 'published',
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Pembersihan saluran drainase dan penimbangan sampah plastik', 'order' => 1],
                ],
            ],
            [
                'title' => 'Porseni Pemuda & Lomba Tradisional Kemerdekaan',
                'slug' => 'porseni-pemuda-lomba-tradisional-kemerdekaan',
                'description' => 'Keceriaan perlombaan tradisional tarik tambang, lari karung, dan futsal sarung antar tempek banjar.',
                'cover_image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=80',
                'event_date' => Carbon::now()->subMonths(4),
                'category' => 'Lomba',
                'order' => 4,
                'status' => 'published',
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=80', 'caption' => 'Keceriaan lomba antar tempek pemuda banjar', 'order' => 1],
                ],
            ],
        ];

        foreach ($albums as $alb) {
            $images = $alb['images'];
            unset($alb['images']);

            $album = GalleryAlbum::updateOrCreate(['slug' => $alb['slug']], $alb);

            foreach ($images as $img) {
                GalleryImage::firstOrCreate(
                    ['album_id' => $album->id, 'image_path' => $img['image_path']],
                    ['caption' => $img['caption'], 'order' => $img['order']]
                );
            }
        }

        // 8. Organizational Positions & Members
        $positions = [
            ['name' => 'Ketua', 'code' => 'KETUA', 'level' => 1, 'order' => 1],
            ['name' => 'Wakil Ketua', 'code' => 'WAKIL_KETUA', 'level' => 1, 'order' => 2],
            ['name' => 'Sekretaris', 'code' => 'SEKRETARIS', 'level' => 2, 'order' => 3],
            ['name' => 'Bendahara', 'code' => 'BENDAHARA', 'level' => 2, 'order' => 4],
            ['name' => 'Koordinator Bidang Seni & Budaya', 'code' => 'KORD_SENI', 'level' => 3, 'order' => 5],
            ['name' => 'Koordinator Bidang Sosial & Lingkungan', 'code' => 'KORD_SOSIAL', 'level' => 3, 'order' => 6],
            ['name' => 'Koordinator Bidang Olahraga & Kreativitas', 'code' => 'KORD_OLAHRAGA', 'level' => 3, 'order' => 7],
            ['name' => 'Koordinator Humas & Dokumentasi', 'code' => 'KORD_HUMAS', 'level' => 3, 'order' => 8],
        ];

        $posModels = [];
        foreach ($positions as $pos) {
            $posModels[$pos['code']] = OrganizationalPosition::updateOrCreate(['code' => $pos['code']], $pos);
        }

        Member::query()->delete();

        $members = [
            [
                'position_id' => $posModels['KETUA']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Ketua STT',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Koordinator kepengurusan STT dari ArtDevata. Bertekad membawa STT menjadi wadah pemuda yang berakar pada adat namun berfikir modern.',
                'phone' => '+62 812-3456-7890',
                'email' => 'ketua@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['WAKIL_KETUA']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Wakil Ketua STT',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Pengurus aktif STT dari ArtDevata. Mengkoordinasikan partisipasi krama teruna dalam kegiatan gotong royong banjar.',
                'phone' => '+62 813-1122-3344',
                'email' => 'wakil@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['SEKRETARIS']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Sekretaris',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Tim Administrasi STT dari ArtDevata. Mengelola tata kelola administrasi, surat menyurat organisasi, dan publikasi media resmi STT.',
                'phone' => '+62 813-9876-5432',
                'email' => 'sekretaris@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['BENDAHARA']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Bendahara',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Tim Keuangan STT dari ArtDevata. Mengawal transparansi keuangan organisasi, iuran bulanan krama, serta akuntabilitas dana operasional banjar.',
                'phone' => '+62 812-4455-6677',
                'email' => 'bendahara@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['KORD_SENI']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Koordinator Bidang Seni & Budaya',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Tim Pengembang Seni dan Budaya dari ArtDevata. Membina kelompok karawitan krama teruna dan pelestarian seni tradisional banjar.',
                'phone' => '+62 819-8877-6655',
                'email' => 'seni@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['KORD_SOSIAL']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Koordinator Bidang Sosial & Lingkungan',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Tim Aksi Sosial dan Lingkungan dari ArtDevata. Inisiator bank sampah mandiri banjar dan koordinator relawan bakti kemanusiaan pemuda.',
                'phone' => '+62 819-3322-1144',
                'email' => 'sosial@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 6,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['KORD_OLAHRAGA']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Koordinator Bidang Olahraga & Kreativitas',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Tim Olahraga dan Kreativitas dari ArtDevata. Penggiat turnamen persahabatan dan olahraga kebugaran teruna banjar.',
                'phone' => '+62 811-9988-7766',
                'email' => 'olahraga@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 7,
                'is_active' => true,
            ],
            [
                'position_id' => $posModels['KORD_HUMAS']->id,
                'name' => 'ArtDevata',
                'position_title' => 'Koordinator Humas & Dokumentasi',
                'period' => '2024 - 2027',
                'photo' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80',
                'bio' => 'Tim Publikasi dan Humas dari ArtDevata. Fotografer kegiatan banjar dan pengelola kanal informasi sosial media STT.',
                'phone' => '+62 812-7788-9900',
                'email' => 'humas@artdevata.net',
                'social_links' => ['instagram' => 'https://instagram.com/artdevata'],
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($members as $mem) {
            Member::updateOrCreate(['position_id' => $mem['position_id']], $mem);
        }

        // 9. Work Programs (Program Kerja)
        $programs = [
            [
                'name' => 'Revitalisasi Tabuh Gong Kebyar dan Tari Tradisional Banjar',
                'slug' => 'revitalisasi-tabuh-gong-kebyar-tari-tradisional',
                'description' => 'Program pembinaan seni karawitan dan tari Bali secara intensif untuk regenerasi pemuda pemudi banjar setiap akhir pekan.',
                'objectives' => "1. Menumbuhkan kecintaan generasi muda terhadap seni gamelan dan tari sakral Bali.\n2. Menyiapkan kontingen penabuh dan penari untuk ngayah di Pura Kahyangan Tiga.\n3. Melestarikan taksu seni tradisi Banjar ArtDevata.",
                'start_date' => Carbon::now()->startOfYear(),
                'end_date' => Carbon::now()->endOfYear(),
                'pic_name' => 'Tim ArtDevata (Kord. Seni)',
                'status' => 'berjalan',
                'documentation_notes' => 'Telah berjalan 18 sesi latihan dengan kehadiran rata-rata 35 teruna teruni.',
            ],
            [
                'name' => 'Bank Sampah Mandiri dan Edukasi Pilah Sampah dari Rumah',
                'slug' => 'bank-sampah-mandiri-edukasi-pilah-sampah',
                'description' => 'Pengelolaan sampah anorganik banjar berbasis ekonomi sirkular yang dioperasikan sepenuhnya oleh krama teruna.',
                'objectives' => "1. Mengurangi timbulan sampah plastik di lingkungan Banjar ArtDevata.\n2. Menghasilkan kas operasional mandiri dari hasil daur ulang.\n3. Mengedukasi krama banjar mengenai pemilahan sampah berbasis sumber.",
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(10),
                'pic_name' => 'Tim ArtDevata (Kord. Sosial)',
                'status' => 'berjalan',
                'documentation_notes' => 'Terkumpul lebih dari 450 kg sampah plastik dalam 2 bulan pertama.',
            ],
            [
                'name' => 'Pembuatan Mahakarya Ogoh-Ogoh Ramah Lingkungan Nyepi Caka 1948',
                'slug' => 'pembuatan-ogoh-ogoh-ramah-lingkungan-caka-1948',
                'description' => 'Perancangan dan pembangunan ogoh-ogoh berbahan alamiah dengan arsitektur tradisi Bali tanpa styrofoam.',
                'objectives' => "1. Menjaga komitmen ramah lingkungan dalam perayaan pangerupukan.\n2. Mewadahi keahlian seni kriya bambu dan pahat krama teruna.\n3. Mempererat persaudaraan gotong royong pemuda banjar.",
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(2),
                'pic_name' => 'Tim ArtDevata (Divisi Kreatif & Seni)',
                'status' => 'berjalan',
                'documentation_notes' => 'Struktur anyaman bambu selesai 65%, proses pembentukan anatomi sedang berlangsung.',
            ],
            [
                'name' => 'Pekan Olahraga & Seni Remaja (Porseni STT Banjar ArtDevata 2026)',
                'slug' => 'porseni-stt-banjar-artdevata-2026',
                'description' => 'Ajang kompetisi olahraga tradisional, bulutangkis, e-sport, dan lomba busana adat kepemudaan antar tempek banjar.',
                'objectives' => "1. Mengembangkan minat bakat olahraga pemuda banjar.\n2. Menjalin keakraban antar warga dan pemuda di seluruh tempek.\n3. Menumbuhkan jiwa sportivitas dan kepemimpinan.",
                'start_date' => Carbon::now()->addMonths(3),
                'end_date' => Carbon::now()->addMonths(4),
                'pic_name' => 'Tim ArtDevata (Kord. Olahraga)',
                'status' => 'rencana',
                'documentation_notes' => 'Proposal anggaran dan penyusunan teknis perlombaan dalam tahap finalisasi.',
            ],
            [
                'name' => 'Penyusunan AD/ART dan Standarisasi Manajemen Organisasi',
                'slug' => 'penyusunan-ad-art-dan-standarisasi-manajemen',
                'description' => 'Penyempurnaan tata tertib, hak & kewajiban krama teruna, serta digitalisasi arsip dokumen organisasi.',
                'objectives' => "1. Menyusun pedoman organisasi yang jelas dan adaptif dengan regulasi desa adat modern.\n2. Membangun transparansi tata kelola kas dan iuran anggota.\n3. Mengarsipkan seluruh dokumen dan karya pemuda secara digital.",
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->subMonths(1),
                'pic_name' => 'Tim ArtDevata (Divisi Sekretariat)',
                'status' => 'selesai',
                'documentation_notes' => 'Telah disahkan dalam Paruman Agung krama Banjar ArtDevata pada bulan lalu.',
            ],
        ];

        foreach ($programs as $prog) {
            WorkProgram::updateOrCreate(['slug' => $prog['slug']], $prog);
        }

        // 10. Documents
        $documents = [
            [
                'title' => 'Anggaran Dasar & Anggaran Rumah Tangga (AD/ART) STT ArtDevata',
                'slug' => 'ad-art-stt-artdevata-2024-2027',
                'category' => 'AD/ART',
                'description' => 'Dokumen resmi landasan hukum, filosofi organisasi, struktur kepengurusan, dan hak serta kewajiban krama teruna teruni.',
                'file_path' => 'documents/AD_ART_STT_ArtDevata.pdf',
                'file_size' => '1.8 MB',
                'downloads_count' => 142,
                'published_at' => Carbon::now()->subMonths(1),
            ],
            [
                'title' => 'Laporan Pertanggungjawaban (LPJ) Karya Nyepi & Pangerupukan Caka 1947',
                'slug' => 'lpj-karya-nyepi-pangerupukan-caka-1947',
                'category' => 'Laporan Kegiatan',
                'description' => 'Laporan akuntabilitas keuangan, realisasi pembuatan ogoh-ogoh, dan dokumentasi evaluasi pawai.',
                'file_path' => 'documents/LPJ_Nyepi_Caka_1947.pdf',
                'file_size' => '3.4 MB',
                'downloads_count' => 88,
                'published_at' => Carbon::now()->subMonths(2),
            ],
            [
                'title' => 'Proposal Program Revitalisasi Instrumen Seni Karawitan Banjar ArtDevata',
                'slug' => 'proposal-revitalisasi-seni-karawitan-banjar-artdevata',
                'category' => 'Proposal',
                'description' => 'Rencana pembiayaan perawatan bilah gong kebyar, pengadaan panggul baru, dan busana ngayah pemuda.',
                'file_path' => 'documents/Proposal_Gong_Kebyar_2026.pdf',
                'file_size' => '2.1 MB',
                'downloads_count' => 64,
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Panduan Tata Tertib & Kode Etik Anggota STT ArtDevata',
                'slug' => 'panduan-tata-tertib-kode-etik-anggota',
                'category' => 'Panduan',
                'description' => 'Pedoman etika berpakaian adat, kehadiran paruman, aturan gotong royong, dan kedisiplinan organisasi.',
                'file_path' => 'documents/Tata_Tertib_STT_2026.pdf',
                'file_size' => '820 KB',
                'downloads_count' => 205,
                'published_at' => Carbon::now()->subMonths(3),
            ],
        ];

        foreach ($documents as $doc) {
            Document::updateOrCreate(['slug' => $doc['slug']], $doc);
        }

        // 11. Pages & Page Sections (For Page Builder & CMS)
        $homePage = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Beranda',
                'slug' => 'home',
                'subtitle' => 'Pusat Informasi Sekaa Teruna Teruni ArtDevata',
                'meta_title' => 'STT ArtDevata — Generasi Muda Bali Berkarya untuk Banjar',
                'meta_description' => 'Platform resmi Sekaa Teruna Teruni ArtDevata Banjar ArtDevata Denpasar Bali.',
                'status' => 'published',
                'order' => 1,
                'is_system' => true,
            ]
        );

        // Home Sections for the Page Builder
        $sections = [
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'hero',
                'title' => 'Generasi Muda ArtDevata, Berkarya untuk Banjar dan Budaya',
                'subtitle' => 'SEKAA TERUNA TERUNI ARTDEVATA',
                'content' => 'Wadah kebersamaan pemuda adat dalam merawat keluhuran tradisi, ngayah tulus ikhlas, dan menyalakan api kreativitas generasi muda tanpa kehilangan jati diri kearifan lokal Bali.',
                'type' => 'custom',
                'data' => [
                    'badge' => 'Sekaa Teruna Teruni • Banjar ArtDevata',
                    'cta_primary_text' => 'Lihat Kegiatan',
                    'cta_primary_url' => '/kegiatan',
                    'cta_secondary_text' => 'Kenali STT',
                    'cta_secondary_url' => '/tentang',
                    'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'about_brief',
                'title' => 'Merajut Semangat Pemuda Berlandaskan Tri Hita Karana',
                'subtitle' => 'TENTANG KAMI',
                'content' => 'Sekaa Teruna Teruni ArtDevata Banjar ArtDevata adalah organisasi kepemudaan adat yang mewadahi teruna dan teruni dalam mengabdikan diri kepada banjar, desa adat, dan tanah Bali.',
                'type' => 'text_image',
                'data' => [
                    'stat_members' => '120+',
                    'stat_members_label' => 'Krama Teruna Teruni Aktif',
                    'stat_programs' => '34+',
                    'stat_programs_label' => 'Kegiatan & Program Terlaksana',
                    'stat_awards' => '18+',
                    'stat_awards_label' => 'Penghargaan Seni & Budaya',
                    'stat_gotong_royong' => '100%',
                    'stat_gotong_royong_label' => 'Berbasis Semangat Ngayah',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'featured_activities',
                'title' => 'Aksi Nyata & Kegiatan Terkini',
                'subtitle' => 'KEGIATAN PEMUDA',
                'content' => 'Dari ngayah di pura, pelestarian seni gamelan, hingga aksi bersih lingkungan dan pembuatan ogoh-ogoh ramah lingkungan.',
                'type' => 'custom',
                'data' => ['limit' => 3],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'upcoming_events',
                'title' => 'Agenda & Rencana Paruman Mendatang',
                'subtitle' => 'AGENDA KEGIATAN',
                'content' => 'Jadwal pertemuan, paruman bulanan, latihan kesenian, dan bakti sosial pemuda banjar.',
                'type' => 'event',
                'data' => ['limit' => 3],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'latest_news',
                'title' => 'Kabar & Warta Organisasi',
                'subtitle' => 'BERITA TERBARU',
                'content' => 'Informasi terpercaya dan dokumentasi artikel seputar perkembangan pemuda adat.',
                'type' => 'news',
                'data' => ['limit' => 3],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'gallery_preview',
                'title' => 'Jejak Visual & Dokumentasi Kreativitas',
                'subtitle' => 'GALERI FOTO',
                'content' => 'Potret autentik kebersamaan, kerja keras, dan keceriaan generasi muda Bali dalam berkarya.',
                'type' => 'gallery',
                'data' => ['limit' => 6],
                'order' => 6,
                'is_active' => true,
            ],
            [
                'page_id' => $homePage->id,
                'page_key' => 'home',
                'section_key' => 'cta_membership',
                'title' => 'Mari Bersinergi Membangun Banjar ArtDevata',
                'subtitle' => 'PASIKIAN PEMUDA',
                'content' => 'Pintu kami senantiasa terbuka bagi seluruh teruna teruni untuk berkontribusi, mengasah kepemimpinan, dan menjaga marwah budaya leluhur.',
                'type' => 'cta',
                'data' => [
                    'cta_button_text' => 'Hubungi Pengurus',
                    'cta_button_url' => '/kontak',
                ],
                'order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $sec) {
            PageSection::updateOrCreate(
                ['page_key' => $sec['page_key'], 'section_key' => $sec['section_key']],
                $sec
            );
        }

        // 12. Contact Messages
        ContactMessage::updateOrCreate(
            ['email' => 'artdevata.warga@example.com'],
            [
                'name' => 'ArtDevata',
                'phone' => '081239874561',
                'subject' => 'Apresiasi Kegiatan Resik Sampah Banjar',
                'message' => 'Om Swastyastu pengurus STT. Kami sekeluarga sangat mengapresiasi keaktifan adik-adik pemuda dalam membersihkan selokan dan menata tanaman banjar kemarin. Semoga semangat ngayah ini terus terjaga.',
                'is_read' => true,
                'replied_at' => Carbon::now()->subDays(2),
            ]
        );

        ContactMessage::updateOrCreate(
            ['email' => 'artdevata.teruni@example.com'],
            [
                'name' => 'ArtDevata',
                'phone' => '087860112233',
                'subject' => 'Pendaftaran Latihan Tari Rejang Piodalan',
                'message' => 'Om Swastyastu, saya warga baru di tempek tengah ingin bergabung latihan tari rejang bersama teruni STT ArtDevata untuk piodalan nanti. Apakah masih bisa mendaftar? Suksema.',
                'is_read' => false,
            ]
        );

        // 13. Default Site Settings & Logo Configuration
        $defaultSettings = [
            'site_name' => 'Sekaa Teruna Teruni ArtDevata',
            'org_name' => 'Sekaa Teruna Teruni ArtDevata',
            'org_short_name' => 'STT ArtDevata',
            'site_short_name' => 'STT ArtDevata',
            'logo_monogram' => 'AD',
            'logo' => '',
            'site_logo' => '',
            'site_tagline' => 'Generasi Muda ArtDevata, Berkarya untuk Banjar dan Budaya',
            'banjar_name' => 'Banjar ArtDevata',
            'desa_adat' => 'Desa Adat ArtDevata',
            'village_name' => 'Desa Adat ArtDevata',
            'contact_address' => 'Balai Banjar ArtDevata, Jl. ArtDevata No. 1, Denpasar, Bali 80223',
            'address' => 'Balai Banjar ArtDevata, Jl. ArtDevata No. 1, Denpasar, Bali 80223',
            'contact_email' => 'sekretariat@artdevata.net',
            'email' => 'sekretariat@artdevata.net',
            'contact_phone' => '+62 361 720188',
            'phone' => '+62 361 720188',
            'contact_whatsapp' => '6281234567890',
            'social_instagram' => 'https://instagram.com/artdevata',
            'social_youtube' => 'https://youtube.com/@artdevata',
            'social_tiktok' => 'https://tiktok.com/@artdevata',
            'seo_meta_title' => 'Sekaa Teruna Teruni ArtDevata - Banjar ArtDevata Bali',
            'seo_meta_description' => 'Platform informasi resmi Sekaa Teruna Teruni (STT) Bali, wadah persatuan, kreativitas, seni budaya, dan pengabdian pemuda adat Banjar ArtDevata.',
        ];

        foreach ($defaultSettings as $key => $val) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $val, 'group' => 'general', 'type' => 'text', 'label' => ucwords(str_replace('_', ' ', $key))]
            );
        }
    }
}
