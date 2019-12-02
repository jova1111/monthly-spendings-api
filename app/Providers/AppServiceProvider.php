<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PlannedMonthlySpendingRepository;
use App\Repositories\Contracts\TransactionRepository;
use App\Repositories\Mongo\MongoUserRepository;
use App\Repositories\Mongo\MongoCategoryRepository;
use App\Repositories\Mongo\MongoPlannedMonthlySpendingRepository;
use App\Repositories\Mongo\MongoTransactionRepository;
use App\Services\Contracts\CategoryService;
use App\Services\Contracts\PlannedMonthlySpendingService;
use App\Services\Contracts\TransactionService;
use App\Services\Contracts\UserService;
use App\Services\DefaultCategoryService;
use App\Services\DefaultPlannedMonthlySpendingService;
use App\Services\DefaultTransactionService;
use App\Services\DefaultUserService;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepository::class => MongoUserRepository::class,
        CategoryRepository::class => MongoCategoryRepository::class,
        TransactionRepository::class => MongoTransactionRepository::class,
        PlannedMonthlySpendingRepository::class => MongoPlannedMonthlySpendingRepository::class,
        UserService::class => DefaultUserService::class,
        CategoryService::class => DefaultCategoryService::class,
        TransactionService::class => DefaultTransactionService::class,
        PlannedMonthlySpendingService::class => DefaultPlannedMonthlySpendingService::class
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
