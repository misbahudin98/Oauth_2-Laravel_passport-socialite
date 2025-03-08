<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Mendefinisikan array
        $customArray = [
            '1' => 'fe.org',
            '2' => 'laravel.org'
        ];

        // Menyimpan array ke dalam service container sehingga dapat diakses via app('custom.config')
        $this->app->instance('callback.config', $customArray);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Passport::hashClientSecrets();

        // PASSPORT_REFRESH
        //         PASSPORT_ACCESS=1
        // PASSPORT_REFRESH=3
        Passport::tokensExpireIn(now()->addMinutes(((int) env("PASSPORT_ACCESS", 30))));
        Passport::refreshTokensExpireIn(now()->addMinutes(((int)  env("PASSPORT_REFRESH", 45))));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
