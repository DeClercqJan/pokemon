<?php

declare(strict_types=1);

require_once("functions.php");
require_once("model.php");

// ALSO SETS DEFAULT LIST OF POKEMON
$pokemons_db = new Pokemons_DB;

// if (isset($_GET["results_page"])) {
//     $new_pokemons_results_page = (int) $_GET["results_page"];
//     // var_dump($new_pokemons_results_page);
//     $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page);
// }

// vertical styling, instead of nesting, for increased readability + yoda logic
// TO DO: add page number
// TO DO: error cases - take into account javascript on the front-end to hide/display suboptions for query_type options
if ("default_browsing" == $_POST["query_type"] && isset($_POST["pokemon_per_page"]) && isset($_POST["results_page"])) {
    echo "case 1 fires";
    // TO DO
    $new_pokemons_results_page = (int) $_GET["pokemon_per_page"];
    var_dump($new_pokemons_results_page);
    //     $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page);
} elseif ("search" == $_POST["query_type"] && isset($_POST["type"]) && isset($_POST["pokemon_per_page"]) && isset($_POST["results_page"])) {
    echo "case 2 fires";
    $type = $_POST["type"];
    $pokemons = $pokemons_db->find_pokemons_by_type($type);
}
$pokemons = $pokemons_db->show_pokemons();

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
    }
}

// HOW TO GET DETAILS OF SPECIFIC POKEMON; ACCEPTS NAME AND ID NUMBER
// $bulbasaur = $pokemons_db->get_pokemon_details("1");
//var_dump_pretty($bulbasaur);

// CHANGE PAGENUMBER TO SET NEXT 20 POKEMON IN CLASS, WHICH YOU THEN GET GET WITH OTHER METHOD
// $pokemons2 = $pokemons_db->change_default_pokemons_results_page(2);
// $pokemons2 = $pokemons_db->show_pokemons();
// var_dump_pretty($pokemons2);
// edit: how to link with pagination? maybe use GET-parameters? 
// var_dump_pretty($_GET);
// var_dump($_GET);
// var_dump($_SERVER);
var_dump($_SERVER["QUERY_STRING"]);

$current_results_page = $pokemons_db->get_pokemons_results_page();
$results_page_all = $pokemons_db->get_pokemons_results_page_all();
