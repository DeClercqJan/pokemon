<?php

require_once("functions.php");

function var_dump_pretty($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

// see readme for note whether or not(not) this was a good idea
// probably best to have this in a return statement, maybe use HEREDOC or so
// question: why can't I say that $favourites is a boolean?
function display_pokemons(array $pokemons, $pokemons_favourited, $favourites = false, int $results_page_all, int $current_results_page, string $query_type, $type, $pokemon_per_page)
{
// probably would work without explictly casting intergers as string, but heu
    $results_page_all_string = (string)$results_page_all;
    $current_results_page_string = (string)$current_results_page;

    if ($favourites) {

        // had to put this in session object as using a hidden html input field did not work with a serialize/unserialize array-value
        $_SESSION["favourited_pokemon_to_mail"] = serialize($pokemons_favourited)

        ?>
        <h2 class="text-center w-100">Pokemon in favourites</h2>
            <form action="/app/src/controller.php" method="POST">
                <label for='email'>Send favourites to someone:</label>
                <input type='email' id='email' name='email'>
                <?php /*// sending data without creating input field
                    */ ?>
                <input type="submit">
            </form>
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
                    <h5 class="card-title"><? echo $pokemon_name ?></h5>
                    <!--                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
                    <a href=<?php echo "'/overview.php?name=" . $pokemon_name . "'" ?> class="btn btn-secondary m-1">Specifications</a>
                    <!--                    <a href=-->
                    <?php //echo "'src/handle_cookie.php?name=" . $pokemon_name . "'"?><!-- class="btn btn-primary m-1">Add to favorite</a>-->
                    <!--                    <form action="src/handle_mail.php" method="POST">-->
                    <!--                        <label for='email'>Enter your email:</label></br>-->
                    <!--                        <input type='email' id='email' name='email'></br>-->
                    <!--                        --><?php ///*// sending data without creating input field
                    //                    */ ?>
                    <!--                        <input type='hidden' name="favourited_pokemon_to_mail"-->
                    <!--                               value=--><?php //echo $pokemon_name; ?><!--/>-->
                    <!--                        <input type="submit">-->
                    <!--                    </form>-->
                </div>
            </div>
            <?php
            /*            }*/
        }
    } elseif
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
                    <a href=<?php echo "src/handle_cookie.php?query_type=$query_type&type=$type&pokemon_per_page=$pokemon_per_page&results_page=$current_results_page_string&name=" . $pokemon_name . "&id=" . $pokemon_id ?>
                       class="btn btn-primary m-1">Add to favorite
                    </a>
                </div>
            </div>
            <?php
        }
        require("pagination.php");
    }
}
