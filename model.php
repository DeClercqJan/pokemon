<?php

declare(strict_types=1);

session_start();

require_once("functions.php");

// to do: abstract class?
// to do: catch errors
//to do: typehints and such, private/public ...
// to do: check if file_get_contents is the best way to proceed compared to PDO, or is that something different? I'm not directly calling database, eh
// can probably refactor the db connection into separate, re-usable function
class Pokemons_DB
{
    // basic logic: set pokemon array with some methods, then use other method to show it. 
    // to do: there's also a details method which operates on another level, more specific that may need to move elsewhere
    private $pokemons = [];
    // this number serves front-end, not api
    private $pokemons_results_page = 1;
    private $pokemons_results_page_all = 0;
    private $pokemon_per_page = 0;

    // not really necessary to have this as null, I think - or is it extra security?
    public function connection_pokemons(int $pagenumber = null, $pokemon_per_page = 20)
    {
        // yoda rule
        if (null != $pagenumber) {
            // need to display this user-end
            $this->pokemons_results_page = $pagenumber;
            // page 1 for the user however, is page 0 for api-call
            $pagenumber_new = $pagenumber - 1;
            $new_pokemons_results_page_call = $pagenumber_new * $pokemon_per_page;
        }
        $limit = $pokemon_per_page;
        $this->pokemon_per_page = $pokemon_per_page;
        // opted to not use standard https://pokeapi.co/api/v2/pokemon but use parameters always for simplicity
        $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon/?offset=$new_pokemons_results_page_call&limit=$limit");
        return json_decode($pokemons_json);
    }

    public function __construct()
    {
        // there are 10157 pokemon in the database it appears, which I have set as parameters to get all
        // $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset=0&limit=10157");
        // yet the assignment wants to display 20 at a time
        $pokemons = $this->connection_pokemons(1);
        $this->pokemons = $pokemons->results;
        $this->pokemons_results_page_all = ceil($pokemons->count / 20);
    }

    private function __destruct()
    {
        // TO DO
    }

    function get_pokemons_results_page()
    {
        return $this->pokemons_results_page;
    }

    function get_pokemons_results_page_all()
    {
        return $this->pokemons_results_page_all;
    }

    function get_pokemon_per_page()
    {
        return $this->pokemon_per_page;
    }

    function change_default_pokemons_results_page(int $pagenumber, int $pokemon_per_page)
    {
        $pokemons = $this->connection_pokemons($pagenumber, $pokemon_per_page);
        $this->pokemons = $pokemons->results;
        $this->pokemons_results_page_all = ceil($pokemons->count / $pokemon_per_page);
    }

    function show_pokemons_type_list()
    {
        // decided not to refactor this in separate connection function as the result is qualitatively different: list of categories versus list of pokemon that match catergory
        $type_data_raw = file_get_contents("https://pokeapi.co/api/v2/type/");
        $type_data = json_decode($type_data_raw);
        $pokemons_type_list = $type_data->results;
        return $pokemons_type_list;
    }

    function pokemon_type_results_to_default_results_logic($pokemons, $pagenumber, $pokemon_per_page)
    {
        $pokemons_count = count($pokemons);
        $this->pokemons_results_page_all = ceil($pokemons_count / $pokemon_per_page);
        $this->pokemons_results_page = $pagenumber;
        $pagenumber_new = $pagenumber - 1;
        $this->pokemon_per_page = $pokemon_per_page;
        $offset = $pagenumber_new * $pokemon_per_page;
        $length = $pokemon_per_page;
        $pokemons2 = array_slice($pokemons, $offset, $length);
        return $pokemons2;
    }
    // notes: chose to only allow string, while integer works too.
    function find_pokemons_by_type(string $type, int $pagenumber, int $pokemon_per_page)
    {
        // decided not to refactor this in separate connection function as the result is qualitatively different: list of categories versus list of pokemon that match catergory
        $all_type_data_json = file_get_contents("https://pokeapi.co/api/v2/type/$type");
        $all_type_data = json_decode($all_type_data_json);
        // needed to reformat this in order to have a uniform pokemons array in this class in order to have re-usable code
        $pokemons = [];
        $pokemons_raw = $all_type_data->pokemon;
        foreach ($pokemons_raw as $pokemon_raw) {
            $pokemon = $pokemon_raw->pokemon;
            array_push($pokemons, $pokemon);
        }
        // need to calculatee the following as it is notreadily available in 
        $pokemons2 = $this->pokemon_type_results_to_default_results_logic($pokemons, $pagenumber, $pokemon_per_page);
        $this->pokemons = $pokemons2;
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
