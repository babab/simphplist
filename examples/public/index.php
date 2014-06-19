<?php
// This file has been placed in the public domain by Benjamin Althues

if (!defined('SIMPHPLIST_EXAMPLES_NO_LOADER') || !SIMPHPLIST_EXAMPLES_NO_LOADER)
    (@include dirname(__DIR__) . "/vendor/autoload.php")
        || die ('Please run `composer install`.');

echo (new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__) . '/tpl')
    ))->loadTemplate('index.tpl')->render(array('subtitle' => 'Index'));
