<?php

declare(strict_types=1);
require_once("test.php");

ini_set('display_errors', On);


session_start();

require_once("functions.php");

// in order to remain on the same page when browsing instead of reverting to default everytme
if(isset($_GET["results_page"])) {
    $current_results_page_string = $_GET["results_page"];
}
if(isset($_GET["query_type"])) {
    $query_type = $_GET["query_type"];
}
if(isset($_GET["type"])) {
    $type = $_GET["type"];
}
if(isset($_GET["pokemon_per_page"])) {
    $pokemon_per_page = $_GET["pokemon_per_page"];
}


if(!isset($_GET["name"])) {
    echo "you need to click add to favourite on the index page first.";
}
elseif (isset($_GET["name"]) && isset($_GET["id"]) && !isset($_COOKIE["favourites"])) {
    $pokemon_name = $_GET["name"];
    $pokemon_id = $_GET["id"];
    $favourites_new = [];
    $pokemon = (object) array('name' => $pokemon_name, 'id' => $pokemon_id);
    // read that this would be better than array_push...
    $favourites_new[] = $pokemon;
    // need to seralize array in order to store in cookie + also need to make sure only unique values are present in array
    $favourites_new_seralized = serialize(array_unique($favourites_new));
    // trying to make it accessible on index by including path
    /* expire in 30 days */
   setcookie("favourites", $favourites_new_seralized, time() + 3600*12*30, "/");
   // header("Location: ../index.php");
    $url = "Location: ../index.php?query_type=$query_type&type=$type&pokemon_per_page=$pokemon_per_page&results_page=$current_results_page_string";
    // var_dump($url);
    header($url);

}

elseif (isset($_GET["name"]) && isset($_GET["id"]) && isset($_COOKIE["favourites"])) {
    $pokemon_name = $_GET["name"];
    $pokemon_id = $_GET["id"];
    $favourites_old = unserialize($_COOKIE["favourites"]);
    // var_dump_pretty($favourites_old);
    $favourites_new = $favourites_old;
    $pokemon = (object) array('name' => $pokemon_name, 'id' => $pokemon_id);
    // read that this would be better than array_push...
    $favourites_new[] = $pokemon;
    // need to seralize array in order to store in cookie + also need to make sure only unique values are present in array
    // need to use SORT REGURLAR to use array unique on objects array
    $array_unique = array_unique($favourites_new, SORT_REGULAR);
    // $favourites_new_seralized = serialize(array_unique($favourites_new));
    $favourites_new_seralized = serialize($array_unique);
    // trying to make it accessible on index by including path
    /* expire in 30 days */
    setcookie("favourites", $favourites_new_seralized, time() + 3600*12*30, "/");
    // header("Location: ../index.php");
    $url = "Location: ../index.php?query_type=$query_type&type=$type&pokemon_per_page=$pokemon_per_page&results_page=$current_results_page_string";
    // var_dump($url);
    header($url);
}