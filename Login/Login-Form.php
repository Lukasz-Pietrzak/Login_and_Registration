<?php
session_start();
require_once "Autoloading.php";
Autoloading::autoloader();


if (isset($_SESSION['nowyLoginiHaslo']) && $_SESSION['nowyLoginiHaslo'] === true){
    issetSession::issetSessionM('przypomnienie_login');
    issetSession::issetSessionM('przypomnienie_haslo');
}

?>


<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

issetSession::issetSessionM('registration_successful');

?>

<form method="post" action="Login-Forwarding.php">

    Login:
    <br>
    <input type="text" name="tekst">
    <br>

    <?php

    issetSession::issetSessionM('empty_tekst');

    ?>

    Password:
    <br>
    <input type="password" name="password">
    <br>

    <?php

    issetSession::issetSessionM('empty_password');

    ?>

    <br>
    <input type="submit" name="submit">

    <?php

    issetSession::issetSessionM('niezalogowany');
    ?>

    <br><br>
</form>

<form method="post" action="../Forgotten%20password/zapomniane_haslo_form.php">

    <input type="submit" value="Have you forgotten password?">
</form>

</body>
</html>