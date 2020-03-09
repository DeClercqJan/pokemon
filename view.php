<?php
declare(strict_types=1);

// phpinfo();

session_start();

// if (isset($_GET)) {
//     var_dump_pretty($_GET);
// }
// if (isset($_POST)) {
//     var_dump_pretty($_POST);
// }
// if (isset($_SESSION)) {
//     var_dump_pretty($_SESSION);
// }
// if (isset($_COOKIE)) {
//     // var_dump_pretty($_COOKIE);
//     if (isset($_COOKIE["favourites"])) {
//         $favourites_old = unserialize($_COOKIE["favourites"]);
//         var_dump($favourites_old);
//     }
// }
// var_dump_pretty($_SERVER);
// var_dump_pretty($_SERVER["QUERY_STRING"]);
$page_selected = $_SERVER["QUERY_STRING"];
// EDIT: ZOU OOK MOETEN WERKEN MET GET  

require_once("functions.php");
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Pokedoki</h1>
    <?php require("pagination.php");
    ?>
    <!-- to do refactor this over  pagination component etc. -->
    <form action="index.php" method="GET">
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
    <?php if (isset($_SESSION["mail_sent"]) && true == $_SESSION["mail_sent"]) {
        echo "mail has been sent!";
        // reset 
        $_SESSION["mail_sent"] = false;
    }
    ?>
    <?php  // just did this this way in order to be quick. But ths really should not be in the view - maybe some synergie/re-use of (parts of) display_pokemons function
    if (isset($_COOKIE["favourites"])) {
        // echo "isset indeed";
    ?>
        <h2>Pokemon in favourites</h2>
        <?php
        $favourites_old = unserialize($_COOKIE["favourites"]);
        foreach ($favourites_old as $favourite) {
            // adapted stuff from display_pokemons function function
            $pokemon_details =  $pokemons_db->get_pokemon_details($favourite);
            echo '<pre>';
            echo $pokemon_details->name;
            echo '</pre>';
            $pokemon_sprite = $pokemon_details->sprites->front_default;
            echo "<img src=" . $pokemon_sprite . ">";
            // overview page
            $pokemon_id = $pokemon_details->id;
            echo "<a href='/overview.php?id=$pokemon_id'>Specifications</a>";
            // echo "<a href='/cookie_handler.php?id=$pokemon_id'>Add to favorite</a>";
        ?>
            <form action="handle_mail.php" method="POST">
                <label for='email'>Enter your email:</label>
                <input type='email' id='email' name='email'>
                <?php // sending data without creating input field 
                ?>
                <input type='hidden' name="favourited_pokemon_to_mail" value=<?php echo $pokemon_details->name; ?> />
                <?php
                ?>
                <input type="submit">
            </form>
    <?php
        }
    }
    ?>
    <h2>Pokemon not necessarily in favourites</h2>
    <?php display_pokemons($pokemons, $pokemons_db); ?>
    <?php require("pagination.php");
    ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
<?php

// what to do with category page? why not index? I think category is just the 'display', so not really a page based on a
