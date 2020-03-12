<?php

require_once("functions.php");

function var_dump_pretty($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

// probably best to have this in a return statement, maybe use HEREDOC or so
// question: why can't I say that $favourites is a boolean?
function display_pokemons(array $pokemons, $pokemons_favourited, $favourites = false, int $results_page_all, int $current_results_page, string $query_type = "default_browsing", $pokemon_per_page = 20)
{
// probably would work without explictly casting intergers as string, but heu
    $results_page_all_string = (string)$results_page_all;
    $current_results_page_string = (string)$current_results_page;

    if ($favourites) {
        ?>
        <h2 class="text-center w-100">Pokemon in favourites</h2>
        <p>maybe this is a good spot if I want only one e-mailinputfield and button. That way the whole page could look
            symmetrical</p>
        <?php
        $pokemons_favourited = $pokemons_favourited->show_pokemons_favourited();
        foreach ($pokemons_favourited as $pokemon_favourited) {
            $pokemon_name = $pokemon_favourited->get_pokemon_property("name");
            ?>
            <!--            <div class="card" style="width: 18rem;">-->
            <!-- note: no bootstrap support for w-20, which would be better -->
            <div class="card w-25 text-center border border-warning">
                <img class="card-img-top"
                     src=<?php echo $pokemon_favourited->get_pokemon_property("image_url") ?> alt="Card
                     image cap">
                <div class="card-body">
                    <h5 class="card-title"><? php echo $pokemon_name ?></h5>
                    <!--                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
                    <a href=<?php echo "'/overview.php?name=" . $pokemon_name . "'" ?> class="btn btn-secondary m-1">Specifications</a>
                    <!--                    <a href=-->
                    <?php //echo "'src/handle_cookie.php?name=" . $pokemon_name . "'"?><!-- class="btn btn-primary m-1">Add to favorite</a>-->
                    <form action="src/handle_mail.php" method="POST">
                        <label for='email'>Enter your email:</label></br>
                        <input type='email' id='email' name='email'></br>
                        <?php /*// sending data without creating input field
                    */ ?>
                        <input type='hidden' name="favourited_pokemon_to_mail"
                               value=<?php echo $pokemon_name; ?>/>
                        <input type="submit">
                    </form>
                </div>
            </div>
            <?php
            /*            }*/
        }
    }// double if statement because the 2 can exist together. edit: no, not necessary as multiple calls are being made

    elseif
    (!$favourites) {
        ?>
        <h2 class="text-center w-100">Pokemon not necessarily in favourites</h2>
        <?php
        require("pagination.php");
        foreach ($pokemons as $pokemon) {
            $pokemon_name = $pokemon->get_pokemon_property("name");
            // $pokemon_url = $pokemon->get_pokemon_property("url");
            // $pokemon_id = $pokemon->get_pokemon_property_from_db($pokemon_url, "id");
            $pokemon_id = $pokemon->get_pokemon_property("id");
            ?>

            <!--            <div class="card" style="width: 18rem;">-->
            <!-- note: no bootstrap support for w-20, which would be better -->
            <div class="card w-25 text-center border border-warning">
                <img class="card-img-top" src=<?php echo $pokemon->get_pokemon_property("image_url") ?> alt="Card image
                     cap">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $pokemon_name ?></h5>
                    <!--                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
                    <a href=<?php echo "'/overview.php?name=" . $pokemon_name . "'" ?> class="btn btn-secondary m-1">Specifications</a>
                    <a href=<?php echo "src/handle_cookie.php?query_type=$query_type&pokemon_per_page=$pokemon_per_page&results_page=$current_results_page_string&name=" . $pokemon_name . "&id=" . $pokemon_id . "&results_page=$current_results_page" ?>
                        class="btn btn-primary m-1">Add to favorite
                    </a>
                </div>
            </div>
            <?php
        }
        require("pagination.php");
    }
}


/*// probably best to have this in a return statement, maybe use HEREDOC or so
// question: why can't I say that $favourites is a boolean?
function display_pokemons(array $pokemons, object $pokemons_db, $favourites = false, int $results_page_all, int $current_results_page )
{
    if($favourites) {
        */ ?>

<?php
/*        $favourites_old = unserialize($_COOKIE["favourites"]);
        foreach ($favourites_old as $favourite) {
            // adapted stuff from display_pokemons function function
            $pokemon_details = $pokemons_db->get_pokemon_details($favourite);
            echo '<pre>';
            echo $pokemon_details->name;
            echo '</pre>';
            $pokemon_sprite = $pokemon_details->sprites->front_default;
            echo "<img src=" . $pokemon_sprite . ">";
            // overview page
            $pokemon_id = $pokemon_details->id;
            echo "<a href='src/overview.php?id=$pokemon_id'>Specifications</a>";
            // echo "<a href='/handle_cookie.php?id=$pokemon_id'>Add to favorite</a>";
            */ ?>


<?php /*// sending data without creating input field
                */ ?>
<?php /*echo $pokemon_details->name; */ ?>
<?php
/*                */ ?>


<?php
/*        }
    }
    // double if statement because the 2 can exist together. edit: no, not necessary as multiple calls are being made
    elseif (!$favourites) {
        */ ?>

<?php
/*        require("pagination.php");
        foreach ($pokemons as $pokemon) {
            echo '<pre>';
            echo $pokemon->name;
            echo '</pre>';
            $pokemon_details =  $pokemons_db->get_pokemon_details($pokemon->name);
            $pokemon_sprite = $pokemon_details->sprites->front_default;
            echo "<img src=" . $pokemon_sprite . ">";
            // overview page
            $pokemon_id = $pokemon_details->id;
            echo "<a href='src/overview.php?id=$pokemon_id'>Specifications</a>";
            echo "<a href='src/handle_cookie.php?id=$pokemon_id'>Add to favorite</a>";
        }
        require("pagination.php");
    }
}*/