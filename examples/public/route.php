<?php
function manual_load()
{
    $d = dirname(dirname(__DIR__));
    require $d . "/src/Simphplist/Simphplist/Route.php";
}
(@include dirname(__DIR__) . "/vendor/autoload.php") || manual_load();

##############################################################################


// When a route is valid the closure function will be run with any
// identifier `/url/:identifier/edit/` matches made available to the
// closure / anonymous function as function arguments.
//
// When a route is matched, any subsequent calls to `when()` or
// `otherwise()` will have no effect. The `setPrefix()`, `when()` and
// `otherwise()` methods can be chained together like below, which will
// read somewhat like a typical if..elseif..else construct.
//
// The API syntax is inspired by:
//
// - Laravel Routing      : using a closure function
// - AngularJS' Route     : `when..otherwise` and `/url/:identifier` syntax
// - AngularJS' Controller: dependency injection based on postional arguments
//
// An `$uri` can have identifiers, which are marked with a leading `:`.
// In the following example there is an 'id' identifier
// for a blog article.
//
// When the url is matched, any values that are matched with
// identifiers are made available as arguments of the closure, in
// left-to-right order. Any extra arguments passed between the
// URI string and the closure function are also made available as
// arguments of the closure, after the identifier arguments.

$foo = 'bar'; // A string that is used in some routes

(new \Simphplist\Simphplist\Route)

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
    \Simphplist\Simphplist\Route::redirect("/route.php/articles/$y/$m/");

})
// When no previous matches are found, redirect to /articles/.
// You could also show a 404 error page here. Otherwise can
// alternatively also accept positional closure arguments, like $foo
->otherwise(function() {

    \Simphplist\Simphplist\Route::redirect("/route.php/articles/");

});
