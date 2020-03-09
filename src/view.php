<?php
declare(strict_types=1);

session_start();

// note: need to place this above rest of html and put everything in variable to I can echo this in this view
require_once("controller.php");

?>
    <!-- starter tempalte https://getbootstrap.com/docs/4.0/getting-started/introduction/ -->
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">

        <title>Hello, world!</title>
    </head>

    <body class="container mw-100 m-0">
    <header class="border border-primary row">
    <h1 class="col-12 text-center" >Pokelidokeli</h1>
    <!-- to do refactor this over  pagination component etc. -->
        <div class="border border-secondary col-12">
    <form action="../index.php" method="GET">
        <label for="query_type">Choose type query</label>
        <select id="query_type" name="query_type">
            <option value="default_browsing">default browsing</option>
            <option value="search">search</option>
        </select>
        <!-- to do: variably display pokemon-type dropdown based on selection of query_type. Javascript? -->
        <label for="type">Choose type from dropdown</label>
        <select id="type" name="type">
            <?php
            $pokemon_type_list = $pokemons_db->show_pokemons_type_list();
            foreach ($pokemon_type_list as $pokemon_type) { ?>
                <option value=<?php echo $pokemon_type->name; ?>><?php echo $pokemon_type->name; ?></option>
            <?php }
            ?>
        </select>
        <!-- note:  I'm not able to calculate beforehand the numer of pokemon that an api call will return (will I search fire or rock? or do I just click to the next default call), I will not set options dynamically but offer to display 5, 10, ... 100  -->
        <label for="pokemon_per_page">Choose # pokemon_per_page</label>
        <select id="pokemon_per_page" name="pokemon_per_page">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <!-- to do: variably display this on the basis of earlier call that + also change the number of pages that are able to be displayed on teh basis of # pokemon in call and # pokemon/page wanted -->
        <label for="results_page">Choose pagenumber</label>
        <select id="results_page" name="results_page">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <input type="submit">
    </form>
        </div>
    </header>
    <main class="border border-primary row">
    <!-- notification that e-mail has indeed been sent -->
    <?php if (isset($_SESSION["mail_sent"]) && true == $_SESSION["mail_sent"]) {
        ?>
        <div class="border border-secondary col-12"> <?php
        echo "mail has been sent!";
        // reset 
        $_SESSION["mail_sent"] = false;
            ?> </div> <?php
    }
    ?>
 <div class="border border-secondary col-8">
    <?php

    // had to passs these in functions. Can probably be done better, but was a result of trying to refactor

    $results_page_all = $pokemons_db->get_pokemons_results_page_all();
    $current_results_page = $pokemons_db->get_pokemons_results_page();

    display_pokemons($pokemons, $pokemons_db, false, $results_page_all, $current_results_page); ?>
        </div>
        <?php  if (isset($_COOKIE["favourites"])) {
            ?>
            <div class="border border-secondary col-4"> <?php
                display_pokemons($pokemons, $pokemons_db, true, $results_page_all, $current_results_page);
                ?> </div>      <?php
        }
        ?>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php

// what to do with category page? why not index? I think category is just the 'display', so not really a page based on a
