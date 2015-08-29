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
            'urls' => $urls,
        ]);
    }

    public static function info()
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

    public static function debug()
    {
        if (App::$debug) {
            phpinfo();
        }
        else {
            echo "Nothing to see here";
        }
    }
}
