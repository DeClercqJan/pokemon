<?php

declare(strict_types=1);

ini_set('display_errors', On);

session_start();

//var_dump($_POST);
//var_dump($_SESSION);

require_once("model.php");

// validation. Note: no validation for pokemons as the e-mail input field is not rendered if no pokemon have been favourited by user
// note: if more field are required, an error array would be best
if (!isset($_POST["email"])) {
    echo "don't access this page directly. You need to favourite at least one 
    pokemon first, enter a valid e-mailadress and click submit";
} elseif (isset($_POST["email"]) && empty($_POST["email"])) {
    $_SESSION["e_mail_error"] = "you have not provided an e-mailadress";
    header("Location: ../index.php");
} elseif (isset($_POST["email"]) && !empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    // note that html also checks for this, but somehow html doesn not trigger and php does trigger an error on example 123@be - which is an invalid email
    $_SESSION["e_mail_error"] = "you have not provided a valid e-mailadress";
    header("Location: ../index.php");
} elseif (isset($_POST["email"]) && !empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    unset($_SESSION["e_mail_error"]);
// to do: clean up this code and make the more advanced mailer work
// to do? Danny says the standard mailer is not recommended, while I do use that one here
    $favourited_pokemon_to_mail = unserialize($_SESSION["favourited_pokemon_to_mail"]);
    $favourited_pokemon_to_mail_array = $favourited_pokemon_to_mail->show_pokemons_favourited();

    function transformer($favourited_pokemon_to_mail_array_singular)
    {
        $favourited_pokemon_to_mail_array_singular2 = "<li><h2>" . $favourited_pokemon_to_mail_array_singular->get_pokemon_property("name") . "</h2></br><p>" . $favourited_pokemon_to_mail_array_singular->get_pokemon_property("image_url") . "</p></li>";
        return $favourited_pokemon_to_mail_array_singular2;
    }

    $favourited_pokemon_to_mail_array_transformed = array_map('transformer', $favourited_pokemon_to_mail_array);

// need this to transform array into string. No options provided as I'm using array map to transform
    $favourited_pokemon_to_mail_string = implode($favourited_pokemon_to_mail_array_transformed);

    $sender = "eddyeddyeddyborremans@gmail.com";

// adapted from https://www.php.net/manual/en/function.mail
// Multiple recipients
// $to = 'johny@example.com, sally@example.com'; // note the comma
    $to = $_POST["email"];

// Subject
    // $subject = 'Look at this pokemon, it is so cool!';
    $subject = 'Look at these pokemon, they are so cool!';

// Message
    $message = "
    <html>
    <head>
      <title>Look at this pokemon, it is so cool!</title>
    </head>
    <body>
<ul> style='color:blue;'>$favourited_pokemon_to_mail_string  </ul>
    </body>
    </html>
    ";

// To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
// $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
    $headers[] = "To <$to>";
    $headers[] = "From: Eddy Borremans <$sender>";
// $headers[] = "Cc: birthdayarchive@example.com";
    $headers[] = "Bcc: $sender";

// Mail it
    if (mail($to, $subject, $message, implode("\r\n", $headers))) {

        var_dump($to, $subject, $message, $headers);
        $_SESSION["mail_sent"] = true;
        header("Location: ../index.php");
    } else {
        $_SESSION["mail_sent"] = false;
        echo "error";
    }
}