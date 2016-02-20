Routing component
=================

Overview
--------

Routing can be handled with the ``Route`` class.

When a route is valid the closure function will be run with any
identifier ``/url/:identifier/edit/`` matches made available to the
closure / anonymous function as function arguments.

When a route is matched, any subsequent calls to ``when()`` or
``otherwise()`` will have no effect. The ``setPrefix()``, ``when()`` and
``otherwise()`` methods can be chained together like in these examples,
which will read somewhat like a typical if..elseif..else construct.

The API syntax is inspired by:

- Laravel Routing      : using a closure function
- AngularJS' Route     : ``when..otherwise`` and ``/url/:identifier`` syntax
- AngularJS' Controller: dependency injection based on postional arguments

Example
-------

index.php:

.. code-block:: php

   <?php
   use \Simphplist\Lib\Route;

   $foo = 'bar'; // A string that is used in some routes

   (new Route)->setPrefix('/index.php')
   ->when('/articles/', function() {
       echo 'This is the article list';
   })
   ->when('/archive/:y/:m/', $foo, function($y, $m, $foo) {
       echo "This is the archive<br>year: $y<br>month: $m";
       echo "<br>Also, foo = $foo";
   })
   ->when('/archive/:void/', function() {
       $y = date('y');
       $m = date('m');
       Route::redirect("/index.php/articles/$y/$m/");
   })
   ->otherwise(function() {
       Route::redirect("/index.php/articles/");
   });
   ?>

Creating a RESTful API
----------------------

Normally, when the first argument passed to ``when()`` is a
string, it will match with any http method (get,post,put,delete, etc.)
used. It is possible to only match on one or more specified
``$_SERVER['REQUEST_METHOD'])``. By passing an array like
``['/url/:id/edit/', 'get']`` as first argument, only GET requests will
match.

Together with Simphplist's Json library, you can use this to create a
RESTful API interface.

index.php:

.. code-block:: php

   <?php

   (new \Simphplist\Lib\Route)
   ->when(['/article/:id/', 'get'], function($id) {

       echo 'Getting article: ' . $id;

   })->when(['/article/new/', 'post'], function() {

       echo 'Adding article: ' . $id;

   })->when(['/article/:id/', 'delete'], function($id) {

       echo 'Article: ' . $id . ' is going to be deleted';

   })->when(['/user/:id/', ['post', 'put']], function($id) {

       echo 'User ID: ' . $id;

   })->otherwise(function() {

       echo 'Invalid route';

   });
   ?>

Class reference
---------------

.. php:namespace:: Simphplist\Lib

.. php:class:: Route

   .. php:method:: setPrefix($prefix)

      Set a prefix (for developing without rewrite support)

      Use this to develop in PHP's built in webserver for example.

      :param string $prefix: The prefix to use. E.g.: ``/api.php``
      :returns: Route. Always returns the initialized route object (for
         method chaining)

      Example:

      .. code-block:: php

         <?php

         $route = new Route;
         $route->setPrefix('index.php');
         ?>

   .. php:method:: when($url, ..., $func)

      Run a closure when the visited URL matches the defined URI format

      An $url can have identifiers, which are marked with a leading ``:``.
      In the example there is an 'id' identifier for a blog article:

      When the url is matched, any values that are matched with
      identifiers are made available as arguments of the closure, in
      left-to-right order. Any extra arguments passed between the
      URL string and the closure function are also made available as
      arguments of the closure, after the identifier arguments.

      :param string|array $url: The URI and/or methods to match against
      :param mixed ...: Optional arguments to pass to closure
      :param callable $func: A closure or variable function to run on match
      :returns: Route. Always returns the initialized route object (for
         method chaining)

      Example:

      .. code-block:: php

         <?php

         $foo = 'bar';

         $route = new Route;
         $route->when('/articles/:id/', function($id) {
             echo 'This is article: ' . $id;
         });
         $route->when('/articles/', function() {
             echo 'This is the article list';
         });
         $route->when('/archive/:y/:m/', $foo, function($y, $m, $foo) {
             echo 'This is article: ' . $id;
         });
         $route->when('/archive/', $foo, function($foo) {
             echo 'This is article: ' . $id;
         });
         ?>

   .. php:method:: otherwise(..., $func)

      Run a default closure when no other previous ``when()`` calls have
      matched and stop routing.

      :param mixed ...: Optional arguments to pass to closure
      :param callable $func: A closure or variable function to run
      :returns: Route. Always returns the initialized route object (for
         method chaining)

      Example:

      .. code-block:: php

         <?php

         $route->otherwise(function() {
             Route::redirect('/articles/');
         });
         ?>

   .. php:method:: parseURI($referencePath, $methods='all')

      **A lower level function, used in the when() method for parsing the URI.**

      Match REQUEST_URI with $reference path. The REQUEST_URI is optionally
      stripped with prefix before matching (useful for developing without
      rewriting rules, with PHP's built in webserver for example). If $methods
      is not 'all', but an array of method names, it will return false when
      the REQUEST_METHOD does not exist in that array.

      - Returns an asscoitative array with matched identifier pairs when applicable;
      - Returns true when a match is found without identifiers;
      - Returns false when no match is found

      :param string $referencePath: The URI format to match for
      :param string|array $methods: String 'all' or an array of method names
      :returns: bool|array Match success bool or matched identifier array

Static methods
--------------

.. php:method:: redirect($uri, $httpPrefixer)

   Redirect to $uri by setting Location header and exit php interpreter

   :param string $uri: The uri
   :param bool $httpPrefixer: Prefix with http:// if no scheme is
      found in $uri
   :returns: Void. Sets header and exists the interpreter!
