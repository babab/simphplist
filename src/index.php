<?php

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = (str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                      . DIRECTORY_SEPARATOR);
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}

autoload('\Babab\Paulos\DB\MysqlHandler');
autoload('\Babab\Paulos\DB\Model');
autoload('\Babab\Paulos\DB\ModelTest');

use \Babab\Paulos\DB\MysqlHandler;
use \Babab\Paulos\DB\ModelTest;

$model = new ModelTest(new MysqlHandler(array(
    'host' => 'localhost',
    'user' => 'root',
    'name' => 'paulos',
    'pw' => '',
    'prefix' => 'paulos_',
)));

$model->id = 34;

if ($model->isValid())
    $model->printInfo();
else {
    echo 'Model is not valid <pre>';
    print_r($model->getValidationErrors());
    echo '</pre>';
}

/* echo "<h2>Model object</h2><hr /><pre>" . print_r($model, true) . "</pre>"; */
