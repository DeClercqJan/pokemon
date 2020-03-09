<?php

declare(strict_types=1);

session_start();

require_once("functions.php");

// note: need to place this above rest of html and put everything in variable to I can echo this in this view
require_once("controller.php");

// if ("/overview" == $_SERVER["PATH_INFO"]) {
    if("/src/overview.php" == $_SERVER["PHP_SELF"]) {
    // echo "test";
    $pokemon_id = (string) $_GET["id"];
    // echo "pokemon id is $pokemon_id";
    $pokemon_details = $pokemons_db->get_pokemon_details($pokemon_id);
    // var_dump_pretty($pokemon_details);
    $pokemon_name = $pokemon_details->name;
    // var_dump($pokemon_name);
    echo "overview echo: $pokemon_name";
}

// question how does this page relate to view and controller?