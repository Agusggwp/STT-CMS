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
            View::composer('*', function ($view) {
                static $memoizedSettings = null;
                static $memoizedUnreadCount = null;

                if ($memoizedSettings === null) {
                    $memoizedSettings = SiteSetting::getAllMap();
                }

                if ($memoizedUnreadCount === null) {
                    // Only compute unread message count for authenticated admins
                    $memoizedUnreadCount = auth()->check()
                        ? ContactMessage::where('is_read', false)->count()
                        : 0;
                }

                $view->with('siteSettings', $memoizedSettings);
                $view->with('unreadMessagesCount', $memoizedUnreadCount);
            });
        } catch (\Throwable $e) {
            // Graceful fallback during migration / CLI
        }
    }
}
