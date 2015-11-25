<?php

namespace Phpuzem\Menufy;

use Illuminate\Support\ServiceProvider;
use Phpuzem\Menufy\Http\Base\MenufyBaseClass;

class MenufyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishassets();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['menufy'] = $this->app->share(function () {
            return new MenufyBaseClass;
        });
        $this->app->alias('menufy', 'Phpuzem\Menufy\Http\Base\MenufyBaseClass');
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    protected function publishassets()
    {
        $this->publishes([
            __DIR__ . '/config/menufy.php' => config_path('menufy.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/database/migrations/create_menufy_table.php' => database_path('migrations/' . $this->getDatePrefix() . '_create_menufy_table.php'),
        ], 'migrations');

    }
}
