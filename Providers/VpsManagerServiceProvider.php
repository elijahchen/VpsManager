<?php

namespace Modules\VpsManager\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class VpsManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'vpsmanager');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('vpsmanager.php'),
        ], 'config');

        $this->registerAssets();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'vpsmanager'
        );
    }

    protected function registerAssets()
    {
        $module_path = module_path('VpsManager');
        $assets_path = $module_path . '/Resources/assets';

        Config::set('modules.vpsmanager.assets_path', $assets_path);

        $this->publishes([
            $assets_path => public_path('modules/vpsmanager'),
        ], 'public');
    }
}