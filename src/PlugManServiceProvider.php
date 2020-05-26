<?php

namespace enesyurtlu\plugman;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class PlugManServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/plugman.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('plugman.php'),
        ], 'config');

        $this->app->alias('PlugMan', 'enesyurtlu\plugman\Facade\PlugManFacade');

        $this->addToBlade(['plugin', 'PlugMan::render(%s);']);
    }

    protected function registerController($array)
    {
        $this->app->alias($array[0], 'Plugins\\' . $array[1]);
    }

    protected function discoverPlugins()
    {
        Config::get("plugman.folder");
    }

    /**
     * Set a blade directive
     *
     * @return void
     */
    protected function addToBlade($array)
    {
        Blade::directive($array[0], function ($data) use ($array) {
            if (!$data) return '<?php echo ' . $array[2] . ' ?>';

            return sprintf(
                '<?php echo ' . $array[1] . ' ?>',
                null !== $data ? $data : "get_defined_vars()['__data']"
            );
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'PlugMan'
        );

        $this->app->bind('PlugMan', function () {
            return new PlugMan();
        });
    }
}
