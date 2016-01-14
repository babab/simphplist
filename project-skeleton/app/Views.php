<?php
namespace Application;

use \Simphplist\Framework\App;

class Views {

    public static function index()
    {
        $urls = App::config('routes');
        unset($urls['__index']);
        $urls[''] = 'index';
        echo App::view('index.html', [
            'debug' => App::config('debug'),
            'prefix' => App::config('debug_prefix'),
            'urls' => $urls,
        ]);
    }

    public static function framework_info()
    {
        if (App::$debug) {
            echo App::view('framework-info.html', [
                'server_info' => $_SERVER,
                'routes' => App::config('routes'),
            ]);
        }
        else {
            echo "Nothing to see here";
        }
    }

    public static function php_info()
    {
        if (App::$debug) {
            phpinfo();
        }
        else {
            echo "Nothing to see here";
        }
    }
}
