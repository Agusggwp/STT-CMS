<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HomepageController as AdminHomepageController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PageSectionController as AdminPageSectionController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WorkProgramController as AdminWorkProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\WorkProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/struktur', [StructureController::class, 'index'])->name('structure');
Route::get('/pengurus', [MemberController::class, 'index'])->name('members');

// Kegiatan (Activities)
Route::get('/kegiatan', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/kegiatan/{slug}', [ActivityController::class, 'show'])->name('activities.show');

// Agenda (Events)
Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
Route::get('/agenda/{slug}', [EventController::class, 'show'])->name('events.show');

// Galeri (Gallery)
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Berita (Posts)
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');

// Program Kerja
Route::get('/program-kerja', [WorkProgramController::class, 'index'])->name('work-programs.index');

// Dokumen
Route::get('/dokumen', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/dokumen/{slug}/unduh', [DocumentController::class, 'download'])->name('documents.download');

// Kontak
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// Halaman Dinamis (Page Builder)
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');

// SEO XML Sitemap & Robots.txt
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Homepage CMS
    Route::get('/homepage', [AdminHomepageController::class, 'index'])->name('homepage.index');
    Route::post('/homepage/hero', [AdminHomepageController::class, 'updateHero'])->name('homepage.hero');
    Route::post('/homepage/footer', [AdminHomepageController::class, 'updateFooter'])->name('homepage.footer');

    // Content Resources
    Route::resource('posts', AdminPostController::class)->names('posts');
    Route::resource('activities', AdminActivityController::class)->names('activities');
    Route::resource('events', AdminEventController::class)->names('events');
    Route::resource('gallery', AdminGalleryController::class)->names('gallery');
    Route::delete('/gallery/images/{image}', [AdminGalleryController::class, 'deleteImage'])->name('gallery.delete-image');
    Route::resource('work-programs', AdminWorkProgramController::class)->names('work-programs');
    Route::resource('members', AdminMemberController::class)->names('members');
    Route::resource('documents', AdminDocumentController::class)->names('documents');

    // Pages & Modular Page Builder
    Route::resource('pages', AdminPageController::class)->names('pages');
    Route::get('/pages/{page}/builder', [AdminPageController::class, 'builder'])->name('pages.builder');
    Route::post('/page-sections', [AdminPageSectionController::class, 'store'])->name('page-sections.store');
    Route::put('/page-sections/{section}', [AdminPageSectionController::class, 'update'])->name('page-sections.update');
    Route::post('/page-sections/reorder', [AdminPageSectionController::class, 'reorder'])->name('page-sections.reorder');
    Route::post('/page-sections/{section}/toggle', [AdminPageSectionController::class, 'toggle'])->name('page-sections.toggle');
    Route::delete('/page-sections/{section}', [AdminPageSectionController::class, 'destroy'])->name('page-sections.destroy');

    // Website Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Media Library
    Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
    Route::put('/media/{medium}', [AdminMediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{medium}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

    // Messages Inbox
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/toggle-read', [AdminMessageController::class, 'toggleRead'])->name('messages.toggle-read');
    Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Super Admin Only
    Route::middleware('superadmin')->group(function () {
        Route::resource('users', AdminUserController::class)->names('users');
        Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});
