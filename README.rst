Simphplist
==============================================================================

Simphplist is a mini-framework with anti-framework features. A
collection of losely coupled components, that helps you with shortcuts
and clean API's for writing the most common idioms when developing web
applications in PHP (MySQL handling, object mapper, authentication,
validation, typechecking).

You can use it as a minimalistic base for writing custom (frameworks
for) applications. Simphplist is carefully designed to allow using it
alongside any other (custom) framework.

Features / Components
------------------------------------------------------------------------------

Simphplist is in the initial stages of development. Some components may
be actually useful already though.

Checkout the API documentation here: http://simphplist.org/annotated.html

DB\\MysqlHandler
  MySQL handler with table prefix support
  [25% done of which 50% documented]

DB\\Model
  Simplistic MySQL Object Mapper
  [20% done of which 0% documented]

Debug
  Static methods for dumping vars to a file or screen (html or text)
  [100% done of which 100% documented]

Json
  Shortcuts for common idioms in JSON interaction
  [50% done of which 0% documented]

Request
  Static methods for secure user input handling via REQUEST superglobal(s):
  (GET, POST, COOKIE)
  [30% done of which 0% documented]

Route
  Minimalistic, flexible and extensible routing
  [50% done of which 80% documented]

String
  Static methods for common string manipulation / parsing tasks
  [60% done of which 20% documented]

Validate
  Clean static API for type checking and validation
  [10% done of which 100% documented]


Overview
------------------------------------------------------------------------------

Routing
#######

index.php::

   <?php
   // -- Include composer for autoloading Simphplist

   (new \Babab\Simphplist\Route)

   // Set a prefix to test in PHP's built in webserver
   ->setPrefix('/index.php')

   ->when('/articles/archive/{year}/{month}/', function($args) {

      echo '<h1>Archives: year "' . $args->year . '"</h1>';
      echo '<h2>Month "' . $args->month . '"</h2>';

   })
   ->when('/articles/{id}/', function($args) {

      echo '<h1>Welcome to article "' . $args->id . '"</h1>';

   })
   ->when('/articles/', function($args) {

      echo '<h1>Welcome to the article list</h1>';

   })
   ->other(function() {

      echo '<h1>No other matches found, this could be a 404 page</h1>';
      // or a redirect
      // \Babab\Simphplist\Route::redirect('/index.php/articles/');

   });


License
------------------------------------------------------------------------------

Copyright (c) 2014  Benjamin Althues <benjamin@babab.nl>

Permission to use, copy, modify, and distribute this software for any
purpose with or without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
