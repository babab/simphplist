<?php
function manual_load()
{
    $d = dirname(dirname(__DIR__));
    require $d . "/src/Babab/Simphplist/Route.php";
}
(@include dirname(__DIR__) . "/vendor/autoload.php") || manual_load();

##############################################################################

(new \Babab\Simphplist\Route)

// set a prefix
->setPrefix('/route.php')

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
    // \Babab\Simphplist\Route::redirect('/route.php/articles/');

});
