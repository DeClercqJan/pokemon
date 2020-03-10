<?php

declare(strict_types=1);

class Pokemon
{
    private $name = "";
    private $url = "";
    private $image_url = "";
    private $testProperty = "Jan De Clercq is the greatest pokemaster of all time";

    public function __construct(object $pokemon_raw)
    {
        // $this->data = $pokemon_raw;
        $this->name = $pokemon_raw->name;
        $this->url = $pokemon_raw->url;
        // $this->image = $this->get_pokemon_property($pokemon_raw->url, "front_default");
        $this->image_url = $this->get_pokemon_property($pokemon_raw->url, "front_default");

    }

    // note: this works for images and SOME properties, BUT for many it doesn't.
    private function get_pokemon_property(string $pokemon_url, string $property)
    {
        // echo "property in get pokemon_property is $property";
        $pokemon_details = $this->get_pokemon_details($pokemon_url, $property);
        // var_dump_pretty($pokemon_details);
        // need to make it an array to use array_column function
        $myArray = json_decode(json_encode($pokemon_details), true);
        // search (multidimensional) array for matching key
        $result_array = array_column($myArray, $property);
        // var_dump_pretty($result_array);
        foreach ($result_array as $key => $value ) {
            // echo "key is $key <br>";
            // echo "value is $value <br>"
            return $value;
        }
        // note to self for future: may need to to typecast for integers ... may need to loop



    }

// api can take both id-number or name of pokemon as input, yet I only use it with string
    private
    function get_pokemon_details(string $pokemon_url, string $property): object
    {
        $pokemon_json = file_get_contents($pokemon_url);
        $pokemon_details = json_decode($pokemon_json);
        return $pokemon_details;
    }

    public function get_image_url() {
        return $this->image_url;

    }

}

class Pokemons
{
    private $pokemons = [];

    public function __construct(array $pokemons_raw)
    {
        foreach ($pokemons_raw as $pokemon_raw) {
            $pokemon = new Pokemon($pokemon_raw);
            $this->pokemons[] = $pokemon;
        }
    }

    public function show_pokemons2(): array
    {
        return $this->pokemons;
    }
}

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
    private function connection_pokemons(int $pagenumber = null, $pokemon_per_page = 20): object
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

    // chosen to write public explicitly for clarity
    public function __construct()
    {
        // there are 10157 pokemon in the database it appears, which I have set as parameters to get all
        // $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset=0&limit=10157");
        // yet the assignment wants to display 20 at a time
        $pokemons = $this->connection_pokemons(1);

//
//        // is this the correct moment to declare this class?
//        $pokemons_class = new Pokemons();
//
//        foreach ($pokemons->results as $pokemon_raw) {
//            // var_dump($pokemon_raw);
//            $pokemon = new Pokemon($pokemon_raw);
//            // var_dump_pretty($pokemon);
//            $pokemons_class->add_pokemon_to_pokemons_array($pokemon);
//        }

        // var_dump_pretty($pokemons_class);

        $this->pokemons = $pokemons->results;
        $float = ceil($pokemons->count / 20);
        $this->pokemons_results_page_all = (int)$float;
    }

    public function get_pokemons_array_raw(): array
    {
        return $this->pokemons;
    }
}
/*// to do: abstract class?
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
    private function connection_pokemons(int $pagenumber = null, $pokemon_per_page = 20): object
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

    // chosen to write public explicitly for clarity
    public function __construct()
    {
        // there are 10157 pokemon in the database it appears, which I have set as parameters to get all
        // $pokemons_json = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset=0&limit=10157");
        // yet the assignment wants to display 20 at a time
        $pokemons = $this->connection_pokemons(1);

//
//        // is this the correct moment to declare this class?
//        $pokemons_class = new Pokemons();
//
//        foreach ($pokemons->results as $pokemon_raw) {
//            // var_dump($pokemon_raw);
//            $pokemon = new Pokemon($pokemon_raw);
//            // var_dump_pretty($pokemon);
//            $pokemons_class->add_pokemon_to_pokemons_array($pokemon);
//        }

        // var_dump_pretty($pokemons_class);

        $this->pokemons = $pokemons->results;
        $float = ceil($pokemons->count / 20);
        $this->pokemons_results_page_all = (int)$float;
    }

    public function get_pokemons_array_raw(): array
    {
        return $this->pokemons;
    }

    public function get_pokemons_results_page(): int
    {
        return $this->pokemons_results_page;
    }

    public function get_pokemons_results_page_all(): int
    {
        return $this->pokemons_results_page_all;
    }

    //
    public function change_default_pokemons_results_page(int $pagenumber, int $pokemon_per_page): int
    {
        $pokemons = $this->connection_pokemons($pagenumber, $pokemon_per_page);
        $this->pokemons = $pokemons->results;
        $float = ceil($pokemons->count / $pokemon_per_page);
        return $this->pokemons_results_page_all = (int)$float;
    }

    public function show_pokemons_type_list(): array
    {
        // decided not to refactor this in separate connection function as the result is qualitatively different: list of categories versus list of pokemon that match catergory
        $type_data_raw = file_get_contents("https://pokeapi.co/api/v2/type/");
        $type_data = json_decode($type_data_raw);
        $pokemons_type_list = $type_data->results;
        return $pokemons_type_list;
    }

    private function pokemon_type_results_to_default_results_logic(array $pokemons, int $pagenumber, int $pokemon_per_page): array
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
    public function find_pokemons_by_type(string $type, int $pagenumber, int $pokemon_per_page): array
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
        return $this->pokemons = $pokemons2;
    }

    public function show_pokemons(): array
    {
        // perhaps it would be better not to call all pokemons in construct but put them here? edit: changed name

        return $this->pokemons;
    }

    // id can be both id-number or name of pokemon
    public function get_pokemon_details($id): object
    {
        // echo "functie pokemon details fires met id = $id";
        $pokemon_json = file_get_contents("https://pokeapi.co/api/v2/pokemon/$id");
        $pokemon = json_decode($pokemon_json);
        // var_dump($pokemon->name);
        return $pokemon;
    }
}*/
