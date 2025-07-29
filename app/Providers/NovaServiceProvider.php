<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Laravel\Nova\Cards\Help;
use App\Models\Products\Item;
use App\Nova\Metrics\NewItems;
use App\Nova\Metrics\NewUsers;
use Nibri10\NovaGrid\NovaGrid;
use App\Nova\Metrics\NewOrders;
use App\Nova\Metrics\BlogsPerDay;
use App\Nova\Metrics\OrdersPerDay;
use App\Observers\NovaItemObserver;
use App\Nova\Metrics\NewSubscribers;
use Illuminate\Support\Facades\Gate;
use App\Nova\Metrics\SubscribePerDay;
use App\Nova\Metrics\ItemsPerOnecSync;
use App\Observers\NovaPromocodeObserver;
use App\Nova\Metrics\OrdersPerPaymentMade;
use GijsG\SystemResources\SystemResources;
use App\Nova\Metrics\OrdersPerDeliveryCost;
use App\Nova\Metrics\OrdersPerDiscountType;
use App\Nova\Metrics\OrdersPerPaymentMethod;
use App\Nova\Metrics\OrdersPerDeliveryMethod;
use Bakerkretzmar\NovaSettingsTool\SettingsTool;
use Laravel\Nova\NovaApplicationServiceProvider;
use Inani\LaravelNovaConfiguration\LaravelNovaConfiguration;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::serving(function () {
            Item::observe(NovaItemObserver::class);
            Promocode::observe(NovaPromocodeObserver::class);
        });

        Nova::userTimezone(function (Request $request) {
            return '+00:00';
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            // ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'donato.kz@mail.ru',
                '7723800@gmail.com'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new OrdersPerDay(),
            new NewOrders,
            new NewItems,
            new OrdersPerDeliveryMethod,
            new OrdersPerPaymentMethod,
            new OrdersPerPaymentMade,
            new SubscribePerDay,
            new NewSubscribers,
            new NewUsers,
            new OrdersPerDiscountType,
            new BlogsPerDay,
            // new ItemsPerOnecSync,
            new OrdersPerDeliveryCost,
            new SystemResources('ram'),
            new SystemResources('cpu'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new LaravelNovaConfiguration(),
            // new SettingsTool,
            new NovaGrid,
        ];
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
