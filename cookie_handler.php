<?php

declare(strict_types=1);

session_start();

require_once("functions.php");

// if (isset($_GET)) {
//     var_dump_pretty($_GET);
// }
// if (isset($_POST)) {
//     var_dump_pretty($_POST);
// }
// if (isset($_SESSION)) {
//     var_dump_pretty($_SESSION);
// }
if (isset($_COOKIE)) {
    var_dump_pretty($_COOKIE);
}

// var_dump_pretty($_SERVER);
// var_dump_pretty($_SERVER["QUERY_STRING"]);  

// note: need to place this above rest of html and put everything in variable to I can echo this in this view
// require_once("controller.php");

$pokemon_id = $_GET["id"];

// to do: need to make sure onyl unqiue elements are added
// to do: redirect (using header, I believe) - and hopefully everyhing else will still work
if (isset($_COOKIE["favourites"])) {
    echo "isset already";
    $favourites_old = unserialize($_COOKIE["favourites"]);
    var_dump_pretty($favourites_old);
    $favourites_new = $favourites_old;
    // read that this would be better than array_push...
    $favourites_new[] = $pokemon_id;
    $favourites_new_seralized = serialize($favourites_new);
    setcookie("favourites", $favourites_new_seralized);
} else {
    echo "has not been set already";
    $favourites_new = [];
    // read that this would be better than array_push...
    $favourites_new[] = $pokemon_id;
    $favourites_new_seralized = serialize($favourites_new);
    setcookie("favourites", $favourites_new_seralized);
}
