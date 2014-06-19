<?php
// This file has been placed in the public domain by Benjamin Althues

(@include dirname(__DIR__) . "/vendor/autoload.php")
    or die ('Please run `composer install`.');

echo (new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__) . '/tpl')
    ))->loadTemplate('index.tpl')->render(array('subtitle' => 'Index'));
