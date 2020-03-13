<?php

declare(strict_types=1);

ini_set('display_errors', On);

session_start();

// validation. Note: no validation for pokemons as the e-mail input field is not rendered if no pokemon have been favourited by user
// note: if more field are required, an error array would be best
if (!isset($_POST["email"])) {
    echo "don't access this page directly. You need to favourite at least one 
    pokemon first, enter a valid e-mailadress and click submit";
} elseif (isset($_POST["email"]) && empty($_POST["email"])) {
    echo "you have not provided an e-mailadress";
    $_SESSION["e_mail_error"] = "you have not provided an e-mailadress";
    header("Location: ../index.php");
} elseif (isset($_POST["email"]) && !empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    // note that html also checks for this, but somehow html doesn not trigger and php does trigger an error on example 123@be - which is an invalid email
    echo "you need to fill in a valid emailadres";
    $_SESSION["e_mail_error"] = "you have not provided a valid e-mailadress";
    header("Location: ../index.php");
} elseif (isset($_POST["email"]) && !empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    unset($_SESSION["e_mail_error"]);
    echo "great succes!";
// to do: clean up this code and make the more advanced mailer work
// to do? Danny says the standard mailer is not recommended, while I do use that one here
    $favourited_pokemon_to_mail = $_POST["favourited_pokemon_to_mail"];
    // var_dump($favourited_pokemon_to_mail);
    $destination = $_POST["email"];
    $sender = "eddyeddyeddyborremans@gmail.com";

    // adapted from https://www.php.net/manual/en/function.mail
    // Multiple recipients
    // $to = 'johny@example.com, sally@example.com'; // note the comma
    $to = $destination;

    // Subject
    $subject = 'Look at this pokemon, it is so cool!';
    // Message
    $message = "
    <html>
    <head>
      <title>Look at this pokemon, it is so cool!</title>
    </head>
    <body>
<p style='color:blue;'>$favourited_pokemon_to_mail</p>
    </body>
    </html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    // Additional headers
    // $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
    $headers[] = "To <$destination>";
    $headers[] = "From: Eddy Borremans <$sender>";
    // $headers[] = "Cc: birthdayarchive@example.com";
    $headers[] = "Bcc: $sender";

    // Mail it
    if (mail($to, $subject, $message, implode("\r\n", $headers))) {
        $_SESSION["mail_sent"] = true;
        header("Location: ../index.php");
    } else {
        $_SESSION["mail_sent"] = false;
        echo "error";
    }
}