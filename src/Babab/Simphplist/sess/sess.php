<?php

session_start();

if (!isset($_SESSION['auth']))
    $_SESSION['auth'] = 0;

if (isset($_GET['login'])) {
    if ($_GET['login'] == '1') {
        $_SESSION['auth'] = 1;
    }
    elseif ($_GET['login'] == '0') {
        $_SESSION['auth'] = 0;
    }
}

echo 'authenticated: ';
if ($_SESSION['auth'])
    echo 'yes';
else
    echo 'no';
