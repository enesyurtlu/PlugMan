<?php

namespace enesyurtlu\PlugMan;

use enesyurtlu\PlugMan\Contracts\PlugManContract;
use Illuminate\Support\Facades\Config;

class PlugMan implements PlugManContract
{
    /**
     * Theme namespace.
     */
    public static $namespace = 'plugman';

    private $pluginDir;

    public function __construct()
    {
        $this->pluginDir = Config::get('plugman.pluginsDir');
    }

    /**
     * @param string $pluginName
     * @return array
     */
    public static function checkPlugin(string $pluginName)
    {
        $requirements = [
            "config.json" => false,
            "index.php" => false,
            "controller.php" => false,
            "routes.php" => false
        ];
        foreach ($requirements as $requirement => $value) {
            if (file_exists(PlugMan::getPluginDir($pluginName) . $requirement)) {
                $requirements[$requirement] = true;
            }
        }
        return $requirements;
    }

    /**
     * @param string $pluginName
     * @return string
     */
    public static function getPluginDir(string $pluginName)
    {
        return base_path() . DIRECTORY_SEPARATOR . config("plugman.pluginsDir") . DIRECTORY_SEPARATOR . $pluginName . DIRECTORY_SEPARATOR;
    }

    public static function render($plugin)
    {
        $script = "<script>" . PlugMan::getScript($plugin) . "</script>";
        $tag = "<" . $plugin . "-plugin></" . $plugin . "-plugin>";
        return $script . $tag;
    }

    public static function getScript($plugin)
    {
        // Get Code
        $script = file_get_contents(PlugMan::getPluginDir($plugin) . DIRECTORY_SEPARATOR . $plugin . "-plugin.js");
        // Change assets folders
        return $script;
    }
}
