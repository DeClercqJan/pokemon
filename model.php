<?php

declare(strict_types=1);

require_once("functions.php");

// question: return directly or set properties?
// question: do I want a new call every time to api or do I want to call api once and 'distribute' everything on my own pages? case in point: some of my calls return 20 pokemons, others more or less. Now I've opted to change names to be clear

// to do: abstract class?
// to do: catch errors
//to do: typehints and such, private/public ...
class Pokemons_DB
{
    // basic logic: set pokemon array with some methods, then use other method to show it. 
    // to do: maybe create class or so to clean up stuff so that the "pokemons" array set by type or by default(pages) is the same in form? BEWARE: some of these calls return different data, but name is always one of them
    // to do: there's also a details method which operates on another level, more specific that may not to move elsewhere
    private $pokemons = [];
    private $pokemons_results_page = 0;

    public function __construct()
    {
        // there are 10157 pokemon in the database it appears, which I have set as parameters to get all
        // $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset=0&limit=10157");
        // yet the assignment wants to display 20 at a time
        $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon");
        $pokemons = json_decode($pokemons_json);
        $this->pokemons = $pokemons->results;
        $this->pokemons_results_page = 1;
    }

    private function __destruct()
    {
        // TO DO
    }

    
    function change_default_pokemons_results_page(int $pagenumber)
    {
        // $current_pokemons_results_page = $this->pokemons_results_page;
        $new_pokemons_results_page = $pagenumber;
        $this->pokemons_results_page = $new_pokemons_results_page;
        $new_pokemons_results_page_call = $new_pokemons_results_page * 20;
        $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon/?offset=$new_pokemons_results_page_call&limit=20");
        $pokemons = json_decode($pokemons_json);
        $this->pokemons = $pokemons->results;
    }

    // notes: chose to only allow string, while integer works too.
    // note: can return more than 20 pokemon -
    function find_pokemons_by_type(string $type)
    {
        $all_type_data_json = file_get_contents("https://pokeapi.co/api/v2/type/$type");
        $all_type_data = json_decode($all_type_data_json);
        // need to select specific property
        $pokemons = $all_type_data->pokemon;
        $this->pokemons = $pokemons;
        // need to reset pokemons_results page as this does not fit the mould of 20 pokemon per call
        $this->pokemons_results_page = 0;
    }
    function show_pokemons()
    {
        // perhaps it would be better not to call all pokemons in construct but put them here? edit: changed name

        return $this->pokemons;
    }

    // id can be both integer or name of pokemon 
    function get_pokemon_details($id)
    {
        $pokemon_json = file_get_contents("https://pokeapi.co/api/v2/pokemon/$id");
        $pokemon = json_decode($pokemon_json);
        return $pokemon;
    }
}
