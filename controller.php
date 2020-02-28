<?php

declare(strict_types=1);

require_once("functions.php");
require_once("model.php");

$pokemons_db = new Pokemons_DB;

// GET DEFAULT LIST OF POKEMON
$pokemons = $pokemons_db->show_pokemons();
// var_dump_pretty($pokemons);
foreach ($pokemons as $pokemon) {
    echo '<pre>';
    echo $pokemon->name;
    echo '<pre>';
    $pokemon_details =  $pokemons_db->get_pokemon_details($pokemon->name);
    $pokemon_sprite = $pokemon_details->sprites->front_default;
    echo "<img src=" . $pokemon_sprite . ">";
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


// GET POKEMONS BY TYPE
// $fire_pokemons = $pokemons_db->find_pokemons_by_type("fire");
// $fire_pokemons = $pokemons_db->show_pokemons();
// var_dump_pretty($fire_pokemons);
if (isset($_POST["type"])) {
    $type = $_POST["type"];
    $pokemons = $pokemons_db->find_pokemons_by_type($type);
    $pokemons = $pokemons_db->show_pokemons();
    // WARNING: this code does work, but is different from other. need to clean up so that the structure of data that $pokemons is reusable 
    foreach ($pokemons as $pokemon) {
        echo '<pre>';
        //     echo $pokemon->name;
        echo $pokemon->pokemon->name;
        echo '<pre>';
        $pokemon_details =  $pokemons_db->get_pokemon_details($pokemon->pokemon->name);
        //     $pokemon_details =  $pokemons_db->get_pokemon_details($pokemon->name);
        $pokemon_sprite = $pokemon_details->sprites->front_default;
        echo "<img src=" . $pokemon_sprite . ">";
    }
}
