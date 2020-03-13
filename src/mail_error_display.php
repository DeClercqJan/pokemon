<?php

declare(strict_types=1);

if (isset($_SESSION["mail_sent"]) && true == $_SESSION["mail_sent"] && !isset($_SESSION["e_mail_error"])) {
    ?>
    <div class="col-12 alert alert-success" role="alert">
        <?php
        echo "mail has been sent";
        unset($_SESSION["mail_sent"]);
        ?>
    </div>
    <?php
} else if (isset($_SESSION["mail_sent"]) && false == $_SESSION["mail_sent"] && !isset($_SESSION["e_mail_error"])) {
    ?>
    <div class="col-12 alert alert-danger" role="alert">
        <?php
        echo "you did nothing wrong, but the mailer failed. Please try again later";
        unset($_SESSION["mail_sent"]);
        ?>
    </div>
    <?php
} elseif (!isset($_SESSION["mail_sent"]) && isset($_SESSION["e_mail_error"])) {
    ?>
    <div class="col-12 alert alert-danger" role="alert">
        <?php
        echo $_SESSION["e_mail_error"];
        echo "email error fires";
        ?>
    </div>
    <?php
}