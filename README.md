# Simphplist

Simphplist is a mini-framework with anti-framework features. A
collection of losely coupled components, that helps you with shortcuts
and clean API's for writing the most common idioms when developing web
applications in PHP (routing, MySQL handling, object mapper,
authentication, validation, typechecking).

You can use it as a minimalistic base for writing custom (frameworks
for) applications. Simphplist is carefully designed to allow using it
alongside any other (custom) framework.


## API Reference

See: http://simphplist.org/annotated.html



## Overview

### Routing

When a route is valid the closure function will be run with any
identifier `/url/:identifier/edit/` matches made available to the
closure / anonymous function as function arguments.

When a route is matched, any subsequent calls to `when()` or
`otherwise()` will have no effect. The `setPrefix()`, `when()` and
`otherwise()` methods can be chained together like below, which will
read somewhat like a typical if..elseif..else construct.

The API syntax is inspired by:

- Laravel Routing      : using a closure function
- AngularJS' Route     : `when..otherwise` and `/url/:identifier` syntax
- AngularJS' Controller: dependency injection based on postional arguments

An `$uri` can have identifiers, which are marked with a leading `:`.
In the following example there is an 'id' identifier
for a blog article.

When the url is matched, any values that are matched with
identifiers are made available as arguments of the closure, in
left-to-right order. Any extra arguments passed between the
URI string and the closure function are also made available as
arguments of the closure, after the identifier arguments.

```php

<?php
// -- Include composer autoloader
//    or require 'src/Babab/Simphplist/Route.php'

$foo = 'bar'; // A string that is used in some routes

(new \Babab\Simphplist\Route)

// Use a prefix for developing without rewrite support
// (for example with PHP's excellent built in webserver)
->setPrefix('/route.php')

->when('/articles/', function() {

    echo 'This is the article list';

})
// The identifier is made available to the closure function
->when('/articles/:id/', function($id) {

    echo 'This is article: ' . $id;

})
// Here $foo is injected into the closure and used
->when('/archive/', $foo, function($foo) {

    echo 'This is the archive main page';
    echo "<br>Also, foo = $foo";

})
// Here $foo is injected into the closure after the identifiers
->when('/archive/:y/:m/', $foo, function($y, $m, $foo) {

    echo "This is the archive<br>year: $y<br>month: $m";
    echo "<br>Also, foo = $foo";

})
// Here any value for `:void` is matched, but not used in the closure,
// the user is redirected to the current year/month instead.
->when('/archive/:void/', function() {

    $y = date('y');
    $m = date('m');
    \Babab\Simphplist\Route::redirect("/route.php/articles/$y/$m/");

})
// When no previous matches are found, redirect to /articles/.
// You could also show a 404 error page here. Otherwise can
// alternatively also accept positional closure arguments, like $foo
->otherwise(function() {

    \Babab\Simphplist\Route::redirect("/route.php/articles/");

});

```

Normally, when the first argument passed to `when()` is a
string, it will match with any http method (get,post,put,delete, etc.)
used. It is possible to only match on one or more specified
`$_SERVER['REQUEST_METHOD'])`. By passing an array like
`['/url/:id/edit/', 'get']` as first argument, only GET requests will
match.

You can use this to create a RESTful API interface.

```php

<?php
// -- Include composer autoloader
//    or require 'src/Babab/Simphplist/Route.php'

(new \Babab\Simphplist\Route)

->setPrefix('/api-route.php')

// This route will only match with GET requests
->when(['/article/:id/', 'get'], function($id) {

    echo 'Getting article: ' . $id;

})
// This route will only match with POST requests
->when(['/article/new/', 'post'], function() {

    echo 'Adding article: ' . $id;

})
// This route will only match with DELETE requests
->when(['/article/:id/', 'delete'], function($id) {

    echo 'Article: ' . $id . ' is going to be deleted';

})
// This route will only match with both GET or PUT requests
->when(['/user/:id/', ['post', 'put']], function($id) {

    echo 'User ID: ' . $id;

})
->otherwise(function() {

    echo 'Invalid route';

});

```


## Features / Components

Simphplist is in the initial stages of development. Some components may
be actually useful already though.


**DB\MysqlHandler**

MySQL handler with table prefix support
[25% done of which 50% documented]

**DB\Model**

Simplistic MySQL Object Mapper
[20% done of which 0% documented]

**Debug**

Static methods for dumping vars to a file or screen (html or text)
[100% done of which 100% documented]

**Json**

Shortcuts for common idioms in JSON interaction
[50% done of which 0% documented]

**Request**

Static methods for secure user input handling via REQUEST superglobal(s):
(GET, POST, COOKIE)
[30% done of which 0% documented]

**Route**

Minimalistic, flexible and extensible routing
[70% done of which 80% documented]

**String**

Static methods for common string manipulation / parsing tasks
[60% done of which 20% documented]

**Validate**

Clean static API for type checking and validation
[10% done of which 100% documented]


## Installing

Install from packagist using composer, by adding a composer.json file:

```json

{
    "name": "myProject",
    "require": {
        "simphplist/simphplist": "dev-master"
    }
}

```

And running `composer install`.

Packagist: https://packagist.org/packages/simphplist/simphplist


## License

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
