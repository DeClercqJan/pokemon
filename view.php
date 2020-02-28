<?php

declare(strict_types=1);

require_once("functions.php");

if (isset($_POST)) {
    var_dump_pretty($_POST);
}
?>

<form action="index.php" method="POST">
    <label for="type">Enter type (NEEDS TO BE DROPDOWN)</label></br>
    <input type="text" name="type" id="type"></input>
    <input type="submit">
</form>

<?php
require_once("controller.php");
