<?php

declare(strict_types=1);

echo "test";

session_start();

/*// to do: clean up this code and make the more advanced mailer work
// to do? Danny says the standard mailer is not recommended, while I do use that one here
// to do: check input e-mail/validation
if (isset($_POST["email"])) {

    echo "post email is set";

    $favourited_pokemon_to_mail = $_POST["favourited_pokemon_to_mail"];
    var_dump($favourited_pokemon_to_mail);
    $destination = $_POST["email"];
    var_dump($destination);
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
<p>$favourited_pokemon_to_mail</p>
    </body>
    </html>
    ";
    var_dump($message);

    $message = "test123 want message geeft gelijk enkel pokemon weer";

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
    mail($to, $subject, $message, implode("\r\n", $headers));
    
    $_SESSION["mail_sent"] = true;

    header("Location: ../index.php");
}*/
