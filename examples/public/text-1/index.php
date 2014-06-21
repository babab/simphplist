<?php
// This file has been placed in the public domain by Benjamin Althues

/* Init composer autoloader and import Simphplist components into namespace
** ------------------------------------------------------------------------ */

if (!defined('SIMPHPLIST_EXAMPLES_NO_LOADER') || !SIMPHPLIST_EXAMPLES_NO_LOADER)
    (@include dirname(dirname(__DIR__)) . "/vendor/autoload.php")
        || die ('Please run `composer install`.');

use \Babab\Simphplist\Request;
use \Babab\Simphplist\String;

/* Initialize Twig template (system)
** ------------------------------------------------------------------------ */

$twig = (new Twig_Environment(
    new Twig_Loader_Filesystem(dirname(dirname(__DIR__)) . '/tpl')
))->loadTemplate('text-1.tpl');

/* Simphplist
** ------------------------------------------------------------------------ */

// Sanitize POST input
$text = Request::post('text');

// Count and differentiate paragraphs, lines, words and chars
$info = String::count($text) ?: array();

$keys_to_skip = array('words_list', 'chars_list',
                      'words_list_perc', 'chars_list_perc');

// Render template
echo $twig->render(array(
    'subtitle' => 'Text example 1',
    'text' => $text,
    'info' => $info,
    'keys_to_skip' => $keys_to_skip
));
