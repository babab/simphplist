<?php
namespace Simphplist\Framework;

use \Simphplist\Lib\Dump;
use \Simphplist\Lib\Route;

class App {
    const DS = DIRECTORY_SEPARATOR;

    public static $debug;

    protected static $_config = [];
    protected static $_initialized = false;
    protected static $_path;

    public static function init($publicPath)
    {
        self::$_path = dirname($publicPath);
        self::$_initialized = true;

        if (self::config('debug')) {
            ini_set('display_errors', '1');
            Dump::$debug = true;
            self::$debug = true;
            self::twig()->enableDebug();
        }
        else {
            ini_set('display_errors', '0');
            Dump::$debug = false;
            self::$debug = false;
            self::twig()->disableDebug();
        }
    }

    public static function makePath($pathComponents)
    {
        if (!self::$_initialized) {
            throw new \Exception(
                "Error: You need to call 'App::init(__DIR__)` first"
            );
        }

        if (!is_array($pathComponents))
            $pathComponents = [$pathComponents];

        $path = self::$_path;
        foreach ($pathComponents as $name) {
            $path .= self::DS . $name;
        }
        return $path;
    }

    public static function view($template, $vars=[])
    {
        if (!self::$_initialized) {
            throw new \Exception(
                "Error: You need to call 'App::init(__DIR__)` first"
            );
        }

        return self::twig()->loadTemplate($template)->render($vars);
    }

    public static function twig()
    {
        if (!self::$_initialized) {
            throw new \Exception(
                "Error: You need to call 'App::init(__DIR__)` first"
            );
        }

        if (!$tplPath = self::config('template_path')) {
            throw new \Exception(
                "Error: You need to set a 'template_path' in app/config.ini"
            );
        }
        $tplPath = self::makePath(explode('/', $tplPath));
        return new \Twig_Environment(new \Twig_Loader_Filesystem($tplPath));
    }

    public static function config($setting = null, $value = null)
    {
        // Initialize config if needed
        if (!self::$_config) {
            $configfile = self::makePath(['app', 'config.ini']);
            if (file_exists($configfile))
                self::$_config = parse_ini_file($configfile, true);
            else
                throw new \Exception(
                    "Error: No config file found in app/config.ini"
                );
        }

        // return a single setting if 1st param is empty
        if (!$setting)
            return self::$_config;

        // return the value of the 1st param if 2nd param is not given
        if (!$value)
            return self::$_config[$setting];

        // override the value of 1st param to 2nd param if 2nd param is given
        self::$_config[$setting] = $value;
        return self::$_config[$setting];
    }

    public static function route()
    {
        if (!self::$_initialized) {
            throw new \Exception(
                "Error: You need to call 'App::init(__DIR__)` first"
            );
        }

        $router = new Route;
        if (self::$debug) {
            $router->setPrefix(self::config('debug_prefix'));
        }

        $urls = self::config('routes');
        if (!$urls) {
            throw new \Exception('[routes] not defined in config.ini');
        }
        if (array_key_exists('__index', $urls)) {
            $router->when('', function() {\Application\Views::index();});
            unset($urls['__index']);
        }
        else {
            throw new \Exception('No _index defined in [routes] in config.ini');
        }

        foreach($urls as $url => $controller) {
            $router->when($url, $controller, function($controller) {
                \Application\Views::{$controller}();
            });
        }

        $router->otherwise(function() {
            http_response_code(404);
            echo "404 - Not Found";
        });
    }
}
