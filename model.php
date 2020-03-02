<?php

declare(strict_types=1);

require_once("functions.php");

// question: return directly or set properties?
// question: do I want a new call every time to api or do I want to call api once and 'distribute' everything on my own pages (maybe using react and state?)? case in point: some of my calls return 20 pokemons, others more or less. Now I've opted to change names to be clear

// to do: abstract class?
// to do: catch errors
//to do: typehints and such, private/public ...
// to do: check if file_get_contents is the best way to proceed compared to PDO
// can probably refactor the db connection into separate, re-usable function
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

    function show_pokemons_type_list()
    {
        $type_data_raw = file_get_contents("https://pokeapi.co/api/v2/type/");
        $type_data = json_decode($type_data_raw);
        $pokemons_type_list = $type_data->results;
        return $pokemons_type_list;
    }

    // notes: chose to only allow string, while integer works too.
    // note: can return more than 20 pokemon -
    function find_pokemons_by_type(string $type)
    {
        $all_type_data_json = file_get_contents("https://pokeapi.co/api/v2/type/$type");
        $all_type_data = json_decode($all_type_data_json);
        // needed to reformat this in order to have a uniform pokemons array in this class in order to have re-usable code
        $pokemons = [];
        $pokemons_raw = $all_type_data->pokemon;
        foreach ($pokemons_raw as $pokemon_raw) {
            $pokemon = $pokemon_raw->pokemon;
            array_push($pokemons, $pokemon);
        }
        $this->pokemons = $pokemons;
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
