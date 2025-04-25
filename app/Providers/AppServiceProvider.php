<?php

namespace App\Providers;
use App\BlogCategory;
use App\Tag;
use File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.partials.sidebar', function($view)
        {
            $categories = BlogCategory::all();
            $tags = Tag::all();
            $view->with(['tags' => $tags, 'categories' => $categories]);
        });

        $menus = [];
        if (File::exists(base_path('resources/laravel-admin/menus.json'))) {
            $menus = json_decode(File::get(base_path('resources/laravel-admin/menus.json')));
            view()->share('laravelAdminMenus', $menus);
        }

        $menu_esurvs = [];
        if (File::exists(base_path('resources/laravel-admin/menu-esurvs.json'))) {
            $menu_esurvs = json_decode(File::get(base_path('resources/laravel-admin/menu-esurvs.json')));
            view()->share('laravelMenuEsurvs', $menu_esurvs);
        }

        $menu_certifys = [];
        if (File::exists(base_path('resources/laravel-admin/menu-certifys.json'))) {
            $menu_certifys = json_decode(File::get(base_path('resources/laravel-admin/menu-certifys.json')));
            view()->share('laravelMenuCertifys', $menu_certifys);
        }

        $menu_experts = [];
        if (File::exists(base_path('resources/laravel-admin/menu-experts.json'))) {
            $menu_experts = json_decode(File::get(base_path('resources/laravel-admin/menu-experts.json')));
            view()->share('laravelMenuExperts', $menu_experts);
        }

        $menu_scope_requests = [];
        if (File::exists(base_path('resources/laravel-admin/menu-scope-requests.json'))) {
            $menu_scope_requests = json_decode(File::get(base_path('resources/laravel-admin/menu-scope-requests.json')));
            view()->share('laravelMenuScopeRequests', $menu_scope_requests);
        }

    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
