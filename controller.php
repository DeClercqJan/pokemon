<?php

declare(strict_types=1);

require_once("functions.php");
require_once("model.php");

// ALSO SETS DEFAULT LIST OF POKEMON
$pokemons_db = new Pokemons_DB;

<<<<<<< HEAD
<<<<<<< HEAD
if (isset($_POST["pokemon_per_page"])) {
    $pokemon_per_page = (int) $_POST["pokemon_per_page"];
    echo "pokemon_per_page is $pokemon_per_page in if isset";
    $new_pokemons_results_page = (int) $_GET["results_page"];
    // var_dump($new_pokemons_results_page);
    $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page, $pokemon_per_page);
}

=======
>>>>>>> parent of 2b926aa... managed to change number of displayed pokemon in one very simple use case (but not others). But did this in a messy way and now need to trace back my steps or even revert to earlier commit to rebuild properly
if (isset($_GET["results_page"])) {
    $new_pokemons_results_page = (int) $_GET["results_page"];
    // var_dump($new_pokemons_results_page);
    $pokemons = $pokemons_db->change_default_pokemons_results_page($new_pokemons_results_page);
}

=======
>>>>>>> parent of 9581213... added functional pagination. Do note the error that page 1 in navigation does not correspond with page 0 in api, which should be the case
// OVERWRITES DEFAULT LIST WITH POKEMON SEARCHED
if (isset($_POST["type"])) {
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
<<<<<<< HEAD

$current_results_page = $pokemons_db->get_pokemons_results_page();
$results_page_all = $pokemons_db->get_pokemons_results_page_all();
<<<<<<< HEAD
$pokemons_total = $pokemons_db->get_pokemons_total();
$pokemon_per_page = $pokemons_db->get_pokemon_per_page();
=======
>>>>>>> parent of 9581213... added functional pagination. Do note the error that page 1 in navigation does not correspond with page 0 in api, which should be the case
=======
>>>>>>> parent of 2b926aa... managed to change number of displayed pokemon in one very simple use case (but not others). But did this in a messy way and now need to trace back my steps or even revert to earlier commit to rebuild properly
