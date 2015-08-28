<?php

function code($code)
{
    echo "```php\n<?php\n$code\n```\n";
}

?>---
title: Simphplist

toc_footers:
  - <a href='https://github.com/babab/simphplist'>Simphplist on Github</a>
  - <a href='https://packagist.org/packages/simphplist/simphplist'>Simphplist on Packagist</a>

search: true
---

# Introduction

**Decoupled (framework) libraries with simplistic API's**

<?php code(<<<'DOC'
include dirname(__DIR__) . "/vendor/autoload.php";

use \Simphplist\Lib\Route;
use \Simphplist\Lib\Dump;
DOC
) ?>

Simphplist helps you with shortcuts and clean API's for writing the
most common idioms when developing web applications in PHP (routing,
debugging, validation and `$_GET`/`$_POST` filtering).

You can use it as a minimalistic base for writing custom (frameworks
for) applications. Simphplist is carefully designed to allow using it
alongside any other (custom) framework.


# Installing

```json
{
    "name": "myProject",
    "require": {
        "simphplist/simphplist": "0.2.*"
    }
}
```

Install from packagist using composer, by adding a `composer.json` file
and running `composer install`.

Packagist: https://packagist.org/packages/simphplist/simphplist


# -- Route

## Overview

<?php code(<<<'DOC'
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
DOC
) ?>

Routing can be done with the `Route` class.

When a route is valid the closure function will be run with any
identifier `/url/:identifier/edit/` matches made available to the
closure / anonymous function as function arguments.

When a route is matched, any subsequent calls to `when()` or
`otherwise()` will have no effect. The `setPrefix()`, `when()` and
`otherwise()` methods can be chained together like in these examples,
which will read somewhat like a typical if..elseif..else construct.

The API syntax is inspired by:

- Laravel Routing      : using a closure function
- AngularJS' Route     : `when..otherwise` and `/url/:identifier` syntax
- AngularJS' Controller: dependency injection based on postional arguments


## :: setPrefix()

`setPrefix($prefix)`

<?php code(<<<'DOC'

$route = new Route;
$route->setPrefix('index.php');
DOC
) ?>

Set a prefix (for developing without rewrite support)

Use this to develop in PHP's built in webserver for example.

Parameter | Type | Description
--------- | ---- | -----------
$prefix | string | The prefix to use. E.g.: `/api.php`

**Returns:** Route

Always returns the initialized route object (for method chaining)


## :: when()

`when($url, ..., $func)`

<?php code(<<<'DOC'

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
DOC
) ?>

Run a closure when the visited URL matches the defined URI format

An $uri can have identifiers, which are marked with a leading `:`.
In the example there is an 'id' identifier for a blog article:

When the url is matched, any values that are matched with
identifiers are made available as arguments of the closure, in
left-to-right order. Any extra arguments passed between the
URI string and the closure function are also made available as
arguments of the closure, after the identifier arguments.

Parameter | Type | Description
--------- | ---- | -----------
$uri | string or array | The URI and/or methods to match against
...  | mixed | Optional arguments to pass to closure
$func | callable | A closure or variable function to run on match

**Returns:** Route

Always returns the initialized route object (for method chaining)


## :: otherwise()

`otherwise(..., $func)`

<?php code(<<<'DOC'

$route->otherwise(function() {
    Route::redirect('/articles/');
});
DOC
) ?>

Run a default closure when no other previous `when()` calls have matched
and stop routing.

Parameter | Type | Description
--------- | ---- | -----------
... | mixed | optional arguments to pass to closure
$func | callable | A closure or variable function to run on match

**Returns:** Route

Always returns the initialized route object (for method chaining)


## :: parseURI()

**A lower level function, used in the when() method for parsing the URI.**

`parseURI($referencePath, $methods='all')`

Match REQUEST_URI with $reference path. The REQUEST_URI is optionally
stripped with prefix before matching (useful for developing without
rewriting rules, with PHP's built in webserver for example). If $methods
is not 'all', but an array of method names, it will return false when
the REQUEST_METHOD does not exist in that array.

Parameter | Type | Description
--------- | ---- | -----------
$referencePath | string | The URI format to match for
$methods | string or array | String 'all' or an array of method names

**Returns:** bool | array

Match success bool or matched identifier array

- Returns an asscoitative array with matched identifier pairs when applicable;
- Returns true when a match is found without identifiers;
- Returns false when no match is found


## Creating a RESTful API

<?php code(<<<'DOC'

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
DOC
) ?>

Normally, when the first argument passed to `when()` is a
string, it will match with any http method (get,post,put,delete, etc.)
used. It is possible to only match on one or more specified
`$_SERVER['REQUEST_METHOD'])`. By passing an array like
`['/url/:id/edit/', 'get']` as first argument, only GET requests will
match.

Together with Simphplist's Json library, you can use this to create a
RESTful API interface.

# -- Dump

## Overview

> "The most effective debugging tool is still careful thought, coupled
> with judiciously placed print statements." -- Brian Kernighan

<?php code(<<<'DOC'
use \Simphplist\Lib\Dump;

$someMapping = [];
for ($i = 0; $i < 20; $i++) {
    $someMapping[$i] = $i * 2;
}

Dump::$debug = true;
Dump::$file = '/var/www/dump.log';
Dump::file($someMapping, $_SERVER);
DOC
) ?>

Static methods for dumping vars to a file or screen (html or text).

The Simphplist debug class is just some fancy wrappers around
`var_dump` and `print_r`, but provides a straight-forward way of dumping
values to either the screen or a file.


<aside class="notice">
You need to explicitly set the value of `Dump::$debug`
</aside>

Simphplist Dump adds protection (for production environments) and
flexibility by using a trigger setting `Dump::$debug` that needs to be
explicitly set to true-ish before it will output anything. Leaving or
setting it at a value that evaluates as false will make sure leftover
debug calls will not do anything. You can set the $debug value to
`text`, `html` or `file` to override the dump method used, no mather
what method is actually called in the code.


## :: $debug

<?php code(<<<'DOC'
use \Simphplist\Lib\Dump;

// Override all debug calls to html()
Dump::$debug = 'html';

// Because of the override, this will actually be dumped as html
Dump::text($_SERVER);
DOC
) ?>

`$debug = false`

Debug value, can be a boolean or a string with the method used for
overriding debug method calls.

## :: $file

`$file = '/tmp/simphplist-debug.log'`

String with the complete path to the dumpfile used in Dump::file method
calls.

## :: $tags

<?php code(<<<'DOC'
use \Simphplist\Lib\Dump;

Dump::$debug = true;

// Echo in a textarea instead of a <pre> block
Dump::$tags = ['<textarea rows="24" style="width: 100%">', '</textarea>'];
Dump::html($_SERVER);
DOC
) ?>

`$tags = ['<pre>', '</pre>']`

A 2-item array with the start and end tags to use when dumping variables
with the `html` method

## :: text()

<?php code(<<<'DOC'
use \Simphplist\Lib\Dump;

Dump::$debug = true;

Dump::text($_SERVER);
DOC
) ?>

`text(..., ...)`

Echo variable as a simple text string

Parameter | Type | Description
--------- | ---- | -----------
... | mixed | one or more variables to dump

**Returns:** void | string

Returns a error string when there are errors, else void

## :: html()

<?php code(<<<'DOC'
use \Simphplist\Lib\Dump;

Dump::$debug = true;

Dump::html($_SERVER);
DOC
) ?>

`html(..., ...)`

Echo variable dumps in an html formatted text string

Parameter | Type | Description
--------- | ---- | -----------
... | mixed | one or more variables to dump

**Returns:** void | string

Returns a error string when there are errors, else void


# License

```text
Copyright (c) 2014-2015  Benjamin Althues <benjamin@babab.nl>

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
```

Simphplist is released under an ISC license, which is functionally
equivalent to the simplified BSD and MIT/Expat licenses, with language
that was deemed unnecessary by the Berne convention removed.
