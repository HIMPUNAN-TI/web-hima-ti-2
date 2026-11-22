<?php

namespace App\Providers;

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
        if (class_exists(\SocialiteProviders\Manager\SocialiteWasCalled::class) && class_exists(\SocialiteProviders\MicrosoftAzure\MicrosoftAzureExtendSocialite::class)) {
            \Illuminate\Support\Facades\Event::listen(
                \SocialiteProviders\Manager\SocialiteWasCalled::class,
                [\SocialiteProviders\MicrosoftAzure\MicrosoftAzureExtendSocialite::class, 'handle']
            );
        }
    }
}
