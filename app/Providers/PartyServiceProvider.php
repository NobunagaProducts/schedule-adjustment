<?php

namespace App\Providers;

use App\Service\PartyService;
use Illuminate\Support\ServiceProvider;

class PartyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('PartyService', PartyService::class);
    }
}
