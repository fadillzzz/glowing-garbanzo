<?php

namespace App\Providers;

use App\Core\Interfaces\Auth\TokenRepository;
use App\Core\Interfaces\User\UserRepository;
use App\DAL\Auth\DBToken;
use App\DAL\User\DBUser;
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
