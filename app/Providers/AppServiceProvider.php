<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

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
        View::composer('layouts.side_nav', function ($view) {
            if (Schema::hasTable('menu')) {
                $menus = Cache::remember('menus_sidebar', now()->addMinutes(5), function () {
                    return \App\Models\Menu::with('groupMenu')
                        ->get()
                        ->groupBy(fn($item) => $item->groupMenu->name);
                });

                $view->with('menus', $menus);
            }
        });
    }
}
