<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\Mongo\MongoUserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Mongo\MongoCategoryRepository;
use App\Repositories\Mongo\MongoTransactionRepository;
use App\Repositories\TransactionRepository;
use App\Services\Contracts\CategoryService;
use App\Services\Contracts\UserService;
use App\Services\DefaultCategoryService;
use App\Services\DefaultTransactionService;
use App\Services\DefaultUserService;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepository::class => MongoUserRepository::class,
        CategoryRepository::class => MongoCategoryRepository::class,
        TransactionRepository::class => MongoTransactionRepository::class,
        UserService::class => DefaultUserService::class,
        CategoryService::class => DefaultCategoryService::class,
        TransactionService::class => DefaultTransactionService::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->formatScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
