<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\CategoryController;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class MenuServiceProvider extends ServiceProvider
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
        $categories = new CategoryController($this->app->request);
        View::composer(['layouts.app', 'sections'], function($view) use($categories)
        {
            $catalog = $categories->getCatalog();
            $route = Route::current() ? Route::current()->getName() : null;
            $view->with(['catalog' => $catalog, 'route' => $route]);
        });
    }
}
