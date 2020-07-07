<?php

namespace Tir\Setting;


use Illuminate\Support\ServiceProvider;
use Tir\Setting\Repository as SettingRepository;
use Tir\Setting\Entities\Setting;


class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
            $this->registerSetting();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/admin.php');
        $this->loadViewsFrom(__DIR__.'/Resources/Views', 'setting');
        $this->loadMigrationsFrom(__DIR__ .'/Database/Migrations');


    }




    /**
     * Register setting binding.
     *
     * @return void
     */
    private function registerSetting()
    {
        $this->app->singleton('setting', function () {
            return new SettingRepository(Setting::allCached());
        });
    }
}
