<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production' || str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        if (class_exists(\SocialiteProviders\Manager\SocialiteWasCalled::class) && class_exists(\SocialiteProviders\MicrosoftAzure\MicrosoftAzureExtendSocialite::class)) {
            \Illuminate\Support\Facades\Event::listen(
                \SocialiteProviders\Manager\SocialiteWasCalled::class,
                [\SocialiteProviders\MicrosoftAzure\MicrosoftAzureExtendSocialite::class, 'handle']
            );
        }
    }
}
