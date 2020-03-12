<?php

declare(strict_types=1);

require_once("model.php");

// gonna try to separate json logic from pokemon class so that I can always use the pokemon classes in code if API changes in structure and I would only need to change a few things in the databaseconfig, not the rest of the code
// TO DO: include this in if/else statements
$pokemons_db2 = new Pokemons_DB;
$pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
$pokemons_class = new Pokemons($pokemons_raw);
$pokemons = $pokemons_class->show_pokemons2();

// put this here as the view should not call classes defined in model, but controller serves that purpose
$pokemons_db2->set_pokemons_type_list_names();
$pokemon_type_list_names = $pokemons_db2->get_pokemons_type_list_names();

// needed for pagination component - part 1 - had to put this here to make pagination work when remaking the whole thing
$results_page_all = $pokemons_db2->get_pokemons_results_page_all();
// echo "results page all is $results_page_all <br>";

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
if(isset($_GET["pokemon_per_page"])) {
    $pokemon_per_page = $_GET["pokemon_per_page"];
}
else {
    $pokemon_per_page = "";
}

if (isset($_GET["query_type"]) && "default_browsing" == $_GET["query_type"] && isset($_GET["pokemon_per_page"]) && isset($_GET["results_page"])) {
    echo "case 1 fires <br>";
    $new_pokemons_results_page = (int)$_GET["results_page"];
    $pokemon_per_page = (int)$_GET["pokemon_per_page"];
    $pokemons_db2->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);
    $pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
    $pokemons_class = new Pokemons($pokemons_raw);
    $pokemons = $pokemons_class->show_pokemons2();
//    $_SESSION["previous_query_type"] = "default_browsing";
//    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
//    $_SESSION["results_page"] = $new_pokemons_results_page;
    // $_SESSION["pokemons"] = $pokemons;
}
else if (isset($_GET["results_page"])){
    echo "case 0 without specific query type in GET fires <br>";
    $new_pokemons_results_page = (int)$_GET["results_page"];
    $pokemons_db2->change_default_pokemons_results_page($new_pokemons_results_page, 20);
    $pokemons_raw = $pokemons_db2->get_pokemons_array_raw();
    $pokemons_class = new Pokemons($pokemons_raw);
    $pokemons = $pokemons_class->show_pokemons2();
}

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
// echo "current results page is $current_results_page <br>";


// $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);

//    $_SESSION["previous_query_type"] = "default_browsing";
//    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
//    $_SESSION["results_page"] = $new_pokemons_results_page;
// $_SESSION["pokemons"] = $pokemons;
// }

/*if ("default_browsing" == $_GET["query_type"] && isset($_GET["results_page"])) {
// if ("default_browsing" == $_GET["query_type"] && isset($_GET["pokemon_per_page"]) && isset($_GET["results_page"])) {
    echo "case 1 (appended) fires <br>";
    $new_pokemons_results_page = (int)$_GET["results_page"];
//    $pokemon_per_page = (int)$_GET["pokemon_per_page"];

    $pokemons = $pokemons_db2->change_default_pokemons_results_page($new_pokemons_results_page);
    // $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);

//    $_SESSION["previous_query_type"] = "default_browsing";
//    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
//    $_SESSION["results_page"] = $new_pokemons_results_page;
    // $_SESSION["pokemons"] = $pokemons;
}*/

/*// ALSO SETS DEFAULT LIST OF POKEMON
$pokemons_db = new Pokemons_DB;


// vertical styling, instead of nesting, for increased readability + yoda logic
// TO DO: add page number
// TO DO: error cases - take into account javascript on the front-end to hide/display suboptions for query_type options
if ("default_browsing" == $_GET["query_type"] && isset($_GET["pokemon_per_page"]) && isset($_GET["results_page"])) {
    echo "case 1 fires <br>";
    $new_pokemons_results_page = (int) $_GET["results_page"];
    $pokemon_per_page = (int) $_GET["pokemon_per_page"];
    $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);
    $_SESSION["previous_query_type"] =  "default_browsing";
    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
    $_SESSION["results_page"] = $new_pokemons_results_page;
    // $_SESSION["pokemons"] = $pokemons;

} elseif ("search" == $_GET["query_type"] && isset($_GET["type"]) && isset($_GET["pokemon_per_page"]) && isset($_GET["results_page"])) {
    echo "case 2 fires <br>";
    $type = $_GET["type"];
    $new_pokemons_results_page = (int) $_GET["results_page"];
    $pokemon_per_page = (int) $_GET["pokemon_per_page"];
    $pokemons = $pokemons_db->find_pokemons_by_type($type, $new_pokemons_results_page, $pokemon_per_page);
    $_SESSION["previous_query_type"] =  "search";
    // this does not appear to work with $type ...
    $_SESSION["type"] = $_GET["type"];
    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
    $_SESSION["results_page"] = $new_pokemons_results_page;
    // $_SESSION["pokemons"] = $pokemons;
}
// to serve pagination component 
elseif (isset($_GET["results_page"]) && isset($_SESSION["previous_query_type"]) && "default_browsing" == $_SESSION["previous_query_type"]) {
    echo "case 3 fires";
    $new_pokemons_results_page = (int) $_GET["results_page"];
    // taking stuff from session array
    $pokemon_per_page = (int) $_SESSION["pokemon_per_page"];
    $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);
    // continue the cycle - ? is this actually necessary?
    $_SESSION["previous_query_type"] =  "default_browsing";
    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
    $_SESSION["results_page"] = $new_pokemons_results_page;
    // $_SESSION["pokemons"] = $pokemons;

} elseif (isset($_GET["results_page"]) && isset($_SESSION["previous_query_type"]) && "search" == $_SESSION["previous_query_type"]) {
    echo "case 4 fires";
    $new_pokemons_results_page = (int) $_GET["results_page"];
    // taking stuff from session array
    $type = $_SESSION["type"];
    $pokemon_per_page = (int) $_SESSION["pokemon_per_page"];
    $pokemons = $pokemons_db->find_pokemons_by_type($type, $new_pokemons_results_page, $pokemon_per_page);
    // continue the cycle - ? is this actually necessary?
    $_SESSION["previous_query_type"] =  "search";
    $_SESSION["type"] = $_SESSION["type"];
    $_SESSION["pokemon_per_page"] = $pokemon_per_page;
    $_SESSION["results_page"] = $new_pokemons_results_page;
    // $_SESSION["pokemons"] = $pokemons;
}

// trying out other way of doing things: separating json logic from pokemon class logic by overwriting original:
$pokemons = $pokemons_db->show_pokemons();
var_dump_pretty($pokemons);
// $pokemons = $pokemons_class->show_pokemons2())*/

// if (isset($_GET["results_page"])) {
//     $new_pokemons_results_page = (int) $_GET["results_page"];
//     // var_dump($new_pokemons_results_page);
//     $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page);
// }


