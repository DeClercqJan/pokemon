<?php

declare(strict_types=1);

require_once("model.php");

// needed to populate function that also includes link to cookie handler and ultimately keep current results page as before favourite request
if(isset($_GET["results_page"])) {
    $current_results_page_string = $_GET["results_page"];
}
else {
    $current_results_page_string = "";
}
if(isset($_GET["query_type"])) {
    $query_type = $_GET["query_type"];
}
else {
    $query_type = "";
}
if(isset($_POST["get"])) {
    $type = $_GET["get"];
}
else {
    $type = "";
}
if(isset($_GET["pokemon_per_page"])) {
    $pokemon_per_page = $_GET["pokemon_per_page"];
}
else {
    $pokemon_per_page = "";
}

// gonna try to separate json logic from pokemon class so that I can always use the pokemon classes in code if API changes in structure and I would only need to change a few things in the databaseconfig, not the rest of the code
$pokemons_db2 = new Pokemons_DB;

// TO DO: include this in if/else statements
$pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
$pokemons_class = new Pokemons($pokemons_raw);
$pokemons = $pokemons_class->show_pokemons2();

// put this here as the view should not call classes defined in model, but controller serves that purpose
$pokemons_db2->set_pokemons_type_list_names();
$pokemon_type_list_names = $pokemons_db2->get_pokemons_type_list_names();

// needed for pagination component - part 1 - had to put this here to make pagination work when remaking the whole thing
$results_page_all = $pokemons_db2->get_pokemons_results_page_all();
// echo "results page all is $results_page_all <br>";

// question: do i need cases 3 and 4 of previous iteration? I used sessions then, but at first glance, I'm done
// to do: check more systematically if all use cases are possibl
if (isset($_GET["query_type"]) && "default_browsing" == $_GET["query_type"] && isset($_GET["pokemon_per_page"]) && isset($_GET["results_page"])) {
    echo "case 1 fires <br>";
    $new_pokemons_results_page = (int)$_GET["results_page"];
    $pokemon_per_page = (int)$_GET["pokemon_per_page"];
    $pokemons_db2->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);
    $pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
    $pokemons_class = new Pokemons($pokemons_raw);
    $pokemons = $pokemons_class->show_pokemons2();
}
elseif (isset($_GET["query_type"]) && "search" == $_GET["query_type"] && isset($_GET["type"]) && isset($_GET["pokemon_per_page"]) && isset($_GET["results_page"])) {
    echo "case 2 fires <br>";
    $type = $_GET["type"];
    $new_pokemons_results_page = (int) $_GET["results_page"];
    $pokemon_per_page = (int) $_GET["pokemon_per_page"];
    // $pokemons_db2->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);
    $pokemons_db2->find_pokemons_by_type($type, $new_pokemons_results_page, $pokemon_per_page);
    $pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
    $pokemons_class = new Pokemons($pokemons_raw);
    $pokemons = $pokemons_class->show_pokemons2();
}

// serve pagination
// to do: need to expand is
elseif (isset($_GET["results_page"])){
    echo "case 0 without specific query type in GET fires <br>";
    $new_pokemons_results_page = (int)$_GET["results_page"];
    $pokemons_db2->change_default_pokemons_results_page($new_pokemons_results_page, 20);
    $pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
    $pokemons_class = new Pokemons($pokemons_raw);
    $pokemons = $pokemons_class->show_pokemons2();
}

// this serves to have more and more pokemon available to search in (for instance to display in favourites). See readme
// this gave headers error so using SESSION instead
// if (!isset($_COOKIE["pokemons_array_of_pokemons_class"])) {
if (!isset($_SESSION["pokemons_array_of_pokemons_class"])) {
    // echo "'cookie not isset has fired";
    $pokemons_class = new Pokemons($pokemons_raw);
    $pokemon_class_serialized = serialize($pokemons_class->show_pokemons2());
    // var_dump($pokemon_class_serialized);
//    setcookie("pokemons_array_of_pokemons_class", $pokemon_class_serialized, time() + 3600 * 12 * 30, "/");
    $_SESSION["pokemons_array_of_pokemons_class"] = $pokemon_class_serialized;

} else {
    // echo "cookie has been recognized";
    $previous_pokemons = unserialize($_SESSION["pokemons_array_of_pokemons_class"]);
    $pokemons_class = new Pokemons($pokemons_raw, $previous_pokemons);
    $pokemon_class_serialized_new = serialize($pokemons_class->show_pokemons2());
    // var_dump($pokemon_class_serialized_new);
    $_SESSION["pokemons_array_of_pokemons_class"] = $pokemon_class_serialized_new;
}

// needed for pagination component - part 2
$current_results_page = $pokemons_db2->get_pokemons_results_page();

// this to limit code in view
if(isset($_COOKIE["favourites"])) {
    $favourites_old = unserialize($_COOKIE["favourites"]);
    $pokemons_favourited = new Pokemons_favourited($favourites_old);
}
