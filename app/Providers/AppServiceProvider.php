<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteInfo;
use App\Models\Database;
use App\Models\Footer;
use App\Models\Link;
use App\Models\Menu;

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
        $websiteInfo = WebsiteInfo::first() ?? new WebsiteInfo;
        View::share('websiteInfo', $websiteInfo);

        $footer = Footer::first() ?? new Footer;
        View::share('footer', $footer);

        $links = Link::orderBy('order_index', 'ASC')->get() ?? new Link;
        View::share('links', $links);

        $menu_pages = Menu::orderBy('order_index', 'ASC')->get() ?? new Menu;
        View::share('menu_pages', $menu_pages);
    }
}
