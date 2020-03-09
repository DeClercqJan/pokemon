<?php

declare(strict_types=1);

session_start();

require_once("model.php");

// ALSO SETS DEFAULT LIST OF POKEMON
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

$pokemons = $pokemons_db->show_pokemons();

// if (isset($_GET["results_page"])) {
//     $new_pokemons_results_page = (int) $_GET["results_page"];
//     // var_dump($new_pokemons_results_page);
//     $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page);
// }

// onyl declares it, doesn't call it
function display_pokemons($pokemons, $pokemons_db)
{
    foreach ($pokemons as $pokemon) {
        echo '<pre>';
        echo $pokemon->name;
        echo '</pre>';
        $pokemon_details =  $pokemons_db->get_pokemon_details($pokemon->name);
        $pokemon_sprite = $pokemon_details->sprites->front_default;
        echo "<img src=" . $pokemon_sprite . ">";
        // overview page
        $pokemon_id = $pokemon_details->id;
        echo "<a href='src/overview.php?id=$pokemon_id'>Specifications</a>";
        echo "<a href='src/cookie_handler.php?id=$pokemon_id'>Add to favorite</a>";

    }
}

$current_results_page = $pokemons_db->get_pokemons_results_page();
$results_page_all = $pokemons_db->get_pokemons_results_page_all();
