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
function display_pokemons(array $pokemons, object $pokemons_db, $favourites = false, int $results_page_all, int $current_results_page )
{
    if($favourites) {
        ?>
        <h2 class="text-center">Pokemon in favourites</h2>
        <?php
        $favourites_old = unserialize($_COOKIE["favourites"]);
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
            // echo "<a href='/cookie_handler.php?id=$pokemon_id'>Add to favorite</a>";
            ?>
            <form action="src/handle_mail.php" method="POST">
                <label for='email'>Enter your email:</label>
                <input type='email' id='email' name='email'>
                <?php // sending data without creating input field
                ?>
                <input type='hidden' name="favourited_pokemon_to_mail" value=<?php echo $pokemon_details->name; ?>/>
                <?php
                ?>
                <input type="submit">
            </form>
            <?php
        }
    }
    // double if statement because the 2 can exist together. edit: no, not necessary as multiple calls are being made
    elseif (!$favourites) {
        ?>
        <h2 class="text-center">Pokemon not necessarily in favourites</h2>
        <?php
        require("pagination.php");
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
            echo "<a href='src/cookie_handler.php?id=$pokemon_id'>Add to favorite</a>";
        }
        require("pagination.php");
    }
}