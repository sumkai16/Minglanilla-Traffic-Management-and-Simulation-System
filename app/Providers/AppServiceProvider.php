<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;

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
        Event::listen(function (Login $event) {
            activity('auth')
                ->causedBy($event->user)
                ->performedOn($event->user)
                ->event('login')
                ->log("User logged in successfully.");
        });

        Event::listen(function (Logout $event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->performedOn($event->user)
                    ->event('logout')
                    ->log("User logged out securely.");
            }
        });

        Event::listen(function (Failed $event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->performedOn($event->user)
                    ->event('failed_login')
                    ->withProperties(['email' => $event->credentials['email'] ?? 'unknown'])
                    ->log("Failed login attempt detected.");
            } else {
                activity('auth')
                    ->event('failed_login')
                    ->withProperties(['email' => $event->credentials['email'] ?? 'unknown'])
                    ->log("Failed login attempt with incorrect credentials.");
            }
        });
    }
}
