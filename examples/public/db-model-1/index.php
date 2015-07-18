<?php
// This file has been placed in the public domain by Benjamin Althues

/* Init composer autoloader and import Simphplist components into namespace
** ------------------------------------------------------------------------ */

if (!defined('SIMPHPLIST_EXAMPLES_NO_LOADER') || !SIMPHPLIST_EXAMPLES_NO_LOADER)
    (@include dirname(dirname(__DIR__)) . "/vendor/autoload.php")
        || die ('Please run `composer install`.');

use \Simphplist\Simphplist\Debug;
use \Simphplist\Simphplist\DB\ModelTest;
use \Simphplist\Simphplist\DB\MysqlHandler;

/*
 * You need to explicitly enable debugging before making any calls to
 * Debug methods
 */
Debug::$debug = true;

/*
 * Initialize the ModelTest database model by injecting an instance of
 * MysqlHandler, which in turn can accept a mysqli instance or a settings
 * array like below.
 */

$model = new ModelTest(new MysqlHandler(array(
    'host' => 'localhost',
    'user' => 'root',
    'name' => 'simphplist',
    'pw' => '',
    'prefix' => 'simphplist_',
)));

/*
 * ModelTest needs an id. Try commenting the line below, and a
 * validation error will occur
 */
$model->id = 1;


if ($model->isValid())
    // Echo out a detailed html-formatted dump of the SQL schema and
    // configuration array of each property in ModelTest $model.
    $model->printInfo();
else {
    echo 'Model is not valid <pre>';
    print_r($model->getValidationErrors());
    echo '</pre>';
}
