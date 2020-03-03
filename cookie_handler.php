<?php

declare(strict_types=1);

session_start();

require_once("functions.php");

$pokemon_id = $_GET["id"];

if (isset($_COOKIE["favourites"])) {
    echo "isset already";
    $favourites_old = unserialize($_COOKIE["favourites"]);
    var_dump_pretty($favourites_old);
    $favourites_new = ($favourites_old);
    // read that this would be better than array_push...
    $favourites_new[] = $pokemon_id;
    // need to seralize array in order to store in cookie + also need to make sure only unique values are present in array
    $favourites_new_seralized = serialize(array_unique($favourites_new));
    setcookie("favourites", $favourites_new_seralized);
    header("Location: index.php");
} else {
    echo "has not been set already";
    $favourites_new = [];
    // read that this would be better than array_push...
    $favourites_new[] = $pokemon_id;
    $favourites_new_seralized = serialize(array_unique($favourites_new));
    setcookie("favourites", $favourites_new_seralized);
    header("Location: index.php");
}
