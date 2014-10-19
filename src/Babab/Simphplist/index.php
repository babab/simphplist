<?php

require "Curl.php";

$url = 'http://localhost/sess.php';
$c = new \Babab\Simphplist\Curl($url . '?login=1');

echo '<pre>';
$test = $c->run()->get('plain');
print_r($test);

/* if (!setcookie('PHPSESSID', $sessid, time() + 3600, '/', 'f.babab.nl')) */
/*     die ("Cookie not set"); */

/* header("Set-Cookie: PHPSESSID=$sessid; path=/"); */
/* header("Location: $url"); */
