<?php
(@include dirname(__DIR__) . "/vendor/autoload.php")
    || die ('Autoloader not found. Please run `composer install`.');

use \Simphplist\Framework\App;
use \Simphplist\Lib\Dump;

try {
    App::init(__DIR__);  # Initialize and load framework configuration
    App::route();        # Start routing, redirecting urls to views

}
catch (\Exception $e) {
    echo App::view('error.html', ['error' => $e]);
}
