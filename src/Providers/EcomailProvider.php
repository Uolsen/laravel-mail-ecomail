<?php

declare(strict_types=1);

namespace InvolveDigital\LaravelMailEcomail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use InvolveDigital\LaravelMailEcomail\Transport\EcomailTransport;

final class EcomailProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../resources/config/laravel-mail-ecomail.php',
            'laravel-mail-ecomail'
        );
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mail::extend('ecomail', fn() => app(EcomailTransport::class));

        $this->publishes([
            __DIR__ . '/../../resources/config/laravel-mail-ecomail.php' => config_path('laravel-mail-ecomail.php'),
        ]);
    }

}
