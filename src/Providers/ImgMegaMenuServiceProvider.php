<?php

namespace Imagewize\ImgMegaMenu\Providers;

use Illuminate\Support\ServiceProvider;
use Imagewize\ImgMegaMenu\MegaMenu;
use Imagewize\ImgMegaMenu\MenuFields;

class ImgMegaMenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('img-mega-menu', function () {
            return new MegaMenu($this->app);
        });

        $this->mergeConfigFrom(
            __DIR__.'/../../config/mega-menu.php',
            'mega-menu'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/mega-menu.php' => $this->app->configPath('mega-menu.php'),
        ], 'config');

        $this->loadViewsFrom(
            __DIR__.'/../../resources/views',
            'img-mega-menu',
        );
        
        // Register menu fields for the mega menu
        add_action('init', function () {
            $menuFields = new MenuFields();
            $menuFields->register();
        });
    }
}
