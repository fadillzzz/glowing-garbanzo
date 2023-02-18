<?php

namespace App\Providers;

use App\Core\Interfaces\TokenRepository;
use App\Core\Interfaces\UserRepository;
use App\DAL\DBToken;
use App\DAL\DBUser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        TokenRepository::class => DBToken::class,
        UserRepository::class => DBUser::class,
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
