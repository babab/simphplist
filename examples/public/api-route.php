<?php
function manual_load()
{
    $d = dirname(dirname(__DIR__));
    require $d . "/src/Babab/Simphplist/Route.php";
}
(@include dirname(__DIR__) . "/vendor/autoload.php") || manual_load();

##############################################################################

// Normally, when the first argument passed to `when()` is a
// string, it will match with any http method (get,post,put,delete)
// used. It is possible to only match on one or more specified
// `$_SERVER[''REQUEST_METHOD]). By passing an array like
// `['/url/:id/edit/', 'get']` as first argument, only GET requests will
// match.
//
// You can use this to create a RESTful API interface

$foo = 'bar'; // A string that is used in some routes

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
// This route will only match with both GET and PUT requests
->when(['/user/:id/', ['post', 'put']], function($id) {

    echo 'User ID: ' . $id;

})
->otherwise(function() {

    echo 'Invalid route';

});
