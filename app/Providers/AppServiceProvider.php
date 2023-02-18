<?php

namespace App\Providers;

use App\Core\Interfaces\TokenInterface;
use App\DAL\DBToken;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        TokenInterface::class => DBToken::class,
    ];

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
        //
    }
}
