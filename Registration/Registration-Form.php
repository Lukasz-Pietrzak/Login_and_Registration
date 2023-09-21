<?php
session_start();

require_once "../Login/Autoloading.php";
Autoloading::autoloader();

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

<script src="https://www.google.com/recaptcha/api.js?render=6LcIKz4mAAAAAEeP6-Bal77phhhnXVhtYgiDMUuG"></script>

<script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcIKz4mAAAAAEeP6-Bal77phhhnXVhtYgiDMUuG', {action: 'submit'}).then(function(token) {
                var response = document.getElementById('token_response');
                response.value = token;

            });
        });
</script>

<form method="post" action="Registration-forwarding.php">

    <input type="hidden" id="token_response" name="token_response">
    Login:
    <br>
    <input type="text" name="tekst" value="<?php

    issetSession::issetSessionM('tekst');

    ?>">
    <br>

    <?php

    issetSession::issetSessionM('empty_tekst');

    issetSession::issetSessionM('invalid_login');

    issetSession::issetSessionM('login_occupied');

    ?>

    Email:
    <br>
    <input type="text" name="email" value="<?php

    issetSession::issetSessionM('email');

    ?>">
    <br>

    <?php
    issetSession::issetSessionM('empty_email');

    issetSession::issetSessionM('invalid_email');

    issetSession::issetSessionM('email_occupied');

    ?>

    Password:
    <br>
    <input type="password" name="password" value="<?php

    issetSession::issetSessionM('password');

    ?>">
    <br>

    <?php

    issetSession::issetSessionM('empty_password');

    issetSession::issetSessionM('invalid_password_minimum');

    issetSession::issetSessionM('invalid_password_maximum');

    issetSession::issetSessionM('invalid_password_characters');

    ?>

    Repeat password:
    <br>
    <input type="password" name="password-repeated" value="<?php

    issetSession::issetSessionM('password-repeated');

    ?>">
    <br>

    <?php

    issetSession::issetSessionM('empty_password-repeated');
    issetSession::issetSessionM('invalid_password_repeated');

    ?>

    <br>
    <input type="checkbox" name="checkbox"<?php
    if(isset($_SESSION['checkbox'])){
        echo 'checked="checked"';
        unset($_SESSION['checkbox']);
    }
    ?>> I accept the regulamin
    <br>

    <?php

    issetSession::issetSessionM('empty_checkbox');

    issetSession::issetSessionM('recaptcha_bot');

    ?>

    <br>
    <input type="submit" name="submit" value="Register">

</form>

</body>
</html>

