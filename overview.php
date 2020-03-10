<?php

declare(strict_types=1);

session_start();

require_once("src/functions.php");

// note: need to place this above rest of html and put everything in variable to I can echo this in this view
require_once("src/controller.php");

if(isset($_GET["name"])) {
    $pokemon_name = (string)$_GET["name"];
    $pokemon = $pokemons_class->find_pokemon_in_pokemons($pokemon_name);
    $testProperty = $pokemon->get_pokemon_property("testProperty");
    echo $testProperty;
}
else {
    echo "you need to select a pokemon on the homepage to see its specifications before coming here!";
}

// question how does this page relate to view and controller? edit: it's more of a page, like index is, no? Or is it more like view? It's a destinatin that is linked to, so I'd call it a page and put it in the main folder