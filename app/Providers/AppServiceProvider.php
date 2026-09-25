<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        try {
            if (Schema::hasTable('site_settings')) {
                View::composer('*', function ($view) {
                    $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
                    $unreadMessagesCount = 0;
                    if (Schema::hasTable('contact_messages')) {
                        $unreadMessagesCount = ContactMessage::where('is_read', false)->count();
                    }

                    $view->with('siteSettings', $settings);
                    $view->with('unreadMessagesCount', $unreadMessagesCount);
                });
            }
        } catch (\Throwable $e) {
            // Graceful fallback during migration / CLI
        }
    }
}
