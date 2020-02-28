<?php

declare(strict_types=1);

require_once("functions.php");

// to do: abstract class?
// to do: catch errors
//to do: typehints and such, private/public ...
class Pokemons_DB
{
    private $pokemons = [];
    private $pokemons_results_page = 0;

    public function __construct()
    {
        // there are 10157 pokemon in the database it appears, which I have set as parameters to get all
        // $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset=0&limit=10157");
        // yet the assignment wants to display 20 at a time
        $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon");
        $pokemons = json_decode($pokemons_json);
        $this->pokemons = $pokemons;
        $this->pokemons_results_page = 1;
    }

    private function __destruct()
    {
        // TO DO
    }

    function get_pokemons()
    {
        // perhaps it would be better not to call all pokemons in construct but put them here?
        return $this->pokemons;
    }

    function change_pokemons_results_page(int $pagenumber)
    {
        // $current_pokemons_results_page = $this->pokemons_results_page;
        $new_pokemons_results_page = $pagenumber;
        $this->pokemons_results_page = $new_pokemons_results_page;
        $new_pokemons_results_page_call = $new_pokemons_results_page * 20;
        $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon/?offset=$new_pokemons_results_page_call&limit=20");
        $pokemons = json_decode($pokemons_json);
        $this->pokemons = $pokemons;
    }

    // id can be both integer or name of pokemon 
    function get_pokemon_details($id)
    {
        $pokemon_json = file_get_contents("https://pokeapi.co/api/v2/pokemon/$id");
        $pokemon = json_decode($pokemon_json);
        return $pokemon;
    }
}
