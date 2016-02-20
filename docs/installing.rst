Installing
==========

You can install from packagist using composer:

.. code-block:: shell

   composer require simphplist/simphplist "0.2.*"

You can also install by adding a ``composer.json`` file like below and
running ``composer install``.

.. code-block:: javascript

   {
       "name": "myProject",
       "require": {
           "simphplist/simphplist": "0.2.*"
       }
   }

Simphplist on Packagist: https://packagist.org/packages/simphplist/simphplist

Autoloading via composer
========================

Simphplist does not have its own autoloader but relies on composer instead.

public/index.php:

.. code-block:: php

   <?php
   include dirname(__DIR__) . "/vendor/autoload.php";

   use \Simphplist\Lib\Route;
   use \Simphplist\Lib\Dump;
   ?>
