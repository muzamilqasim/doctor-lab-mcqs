<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $general = gs();
        $home = hs();
        
        $viewShare['general'] = $general;
        $viewShare['home'] = $home;
        view()->share($viewShare);
        view()->composer('admin.partials.navbar', function ($view) {
            $view->with([
                'adminNotifications' => Notification::where('is_read', Status::NO)->orderBy('id', 'desc')->take(7)->get(),
                'adminNotificationCount' => Notification::where('is_read', Status::NO)->count(),
            ]);
        });
       
        
        Paginator::useBootstrapFive();
    }
}
