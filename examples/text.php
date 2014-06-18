<?php
// This file has been placed in the public domain by Benjamin Althues

/* Init composer autoloader and import Simphplist components into namespace
** ------------------------------------------------------------------------ */

(@include "vendor/autoload.php") or die ('Please run `composer install`.');

use \Babab\Simphplist\Request;
use \Babab\Simphplist\String;

/* Initialize Twig template (system)
** ------------------------------------------------------------------------ */

$twig = (new Twig_Environment(
    new Twig_Loader_Filesystem(__DIR__ . '/tpl')
))->loadTemplate('text.tpl');

/* Simphplist
** ------------------------------------------------------------------------ */

// Filter user input
$text = Request::post('text');

// Analyze user input
$info = String::count($text) ?: array();

// Render template
echo $twig->render(array(
    'subtitle' => 'Request and String',
    'text' => $text,
    'info' => $info
));
