<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
         Event::listen(Login::class, function ($event) {
            $guard = config('auth.defaults.guard'); 
            if ($guard === 'web') { 
                $user = $event->user;

                if ($user instanceof \App\Models\User) { 
                    $user->update([
                        'last_login' => now(),
                        'last_ip' => request()->ip(),
                    ]);
                }
            }
        });
    }
}
