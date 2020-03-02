<?php

declare(strict_types=1);

require_once("functions.php");
// note: need to place this above rest of html and put everything in variable to I can echo this in this view
require_once("controller.php");

if (isset($_POST)) {
    var_dump_pretty($_POST);
}

// "had to run but was in the process of setting url-parameters in ahrefs of bootstrap navigation with number. Beware that page 1 is page 0 for API. Also need to catch it and change options dynamically."
// CHANGE PAGENUMBER TO SET NEXT 20 POKEMON IN CLASS, WHICH YOU THEN GET GET WITH OTHER METHOD
// $pokemons2 = $pokemons_db->change_default_pokemons_results_page(2);
// $pokemons2 = $pokemons_db->show_pokemons();
// var_dump_pretty($pokemons2);
// edit: how to link with pagination? maybe use GET-parameters? 
// var_dump_pretty($_GET);
// var_dump($_GET);
// var_dump($_SERVER);
var_dump_pretty($_SERVER["QUERY_STRING"]);
$page_selected = $_SERVER["QUERY_STRING"];
// EDIT: ZOU OOK MOETEN WERKEN MET GET  

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
    <h1>Hello, world!</h1>
    <?php echo "total pokemons is $pokemons_total. Current page is number $current_results_page of $results_page_all total pages at a ratio of $pokemon_per_page pokemon per page"; ?>
    <?php require("pagination.php"); ?>
    <form action="index.php" method="POST">
        <label for="type">Choose type from dropdown</label>
        <!-- <input type="text" name="type" id="type"></input> -->
        <select id="type" name="type">
            <?php
            $pokemon_type_list = $pokemons_db->show_pokemons_type_list();
            foreach ($pokemon_type_list as $pokemon_type) { ?>
                <option value=<?php echo $pokemon_type->name; ?>><?php echo $pokemon_type->name; ?></option>
            <?php }
            ?>
        </select>
        <input type="submit">
    </form>
    <form action="index.php" method="POST">
        <label for="pokemon_per_page">Choose # pokemon_per_page</label>
        <select id="pokemon_per_page" name="pokemon_per_page">
            <?php
            for ($i = 1; $i < $pokemons_total; $i++) {
            ?>
                <option value=<?php echo $i ?>><?php echo $i; ?></option>
            <?php
            }
            ?>
        </select>
        <input type="submit">
    </form>
    <?php require("pagination.php"); ?>
    </form>
    <?php display_pokemons($pokemons, $pokemons_db); ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
<?php


// what to do with category page? why not index?
