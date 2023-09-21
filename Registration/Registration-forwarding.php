<?php

session_start();
require_once "../Login/Autoloading.php";
Autoloading::autoloader();


if ($_POST['submit']){

    $udana_walidacja = true;

    //Set session name
    function sessionPost(array $name){
        foreach ($name as $names){
            $_SESSION["$names"] = $_POST["$names"];
        }
    }

    //Redirect if the field in form is empty
    function emptyDataM(array $fields, string $location) {
        foreach ($fields as $fieldName) {
            if (empty($_POST[$fieldName])) {
                global $udana_walidacja;
                handleErrorAndRedirect::handleErrorRedirectM("empty_$fieldName","$fieldName cannot be empty", "$location");
                $udana_walidacja = false;
            }
        }
    }

    //This part of code rember the fields writing by user
    sessionPost(['tekst', 'password', 'password-repeated', 'email', 'checkbox']);


    //This part of code checking if the fields is empty - in this case return error message
    $sessions = ['tekst', 'password', 'password-repeated', 'email', 'checkbox'];

    $location = 'Registration-Form.php';
    emptyDataM($sessions, $location);


    $user = $_POST['tekst'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeated = $_POST['password-repeated'];

    // Error handling - Login containing not allowed characters
    if (!ctype_alnum($user) && !empty($user)) {
        handleErrorAndRedirect::handleErrorRedirectM("invalid_login", "Login might only contain alphanumeric characters", $location);
        $udana_walidacja = false;
    }

    // Error handling - Email must have proper type of format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        handleErrorAndRedirect::handleErrorRedirectM("invalid_email", "Email must have proper type of format", $location);
        $udana_walidacja = false;
        exit();
    }



    $dbconnection = new DbConnect();
    $dbconnection->DatabaseConnection('localhost', 'root', '', 'osadnicy');

//Query checking if login is occupied
    $databaseQuerry1 = new DatabaseQuerry($dbconnection);
    $databaseQuerry1->DatabaseQuerryM("SELECT user FROM uzytkownicy where user='$user'");

    //Check if login is occupied
    $AccessControl = new AccessControl($databaseQuerry1);
    if ($AccessControl->FetchAccessControlM() && !empty($user)){
        handleErrorAndRedirect::handleErrorRedirectM("login_occupied", "Login is occupied", $location);
        $udana_walidacja = false;
        exit();
    }

    //Next query checking if email is occupied
    $databaseQuerry2 = clone $databaseQuerry1;
    $databaseQuerry2->DatabaseQuerryM("SELECT email FROM uzytkownicy where email='$email'");

    $AccessControl = new AccessControl($databaseQuerry2);

    if ($AccessControl->FetchAccessControlM() && !empty($email)){
        handleErrorAndRedirect::handleErrorRedirectM("email_occupied", "Email is occupied", $location);
        $udana_walidacja = false;
        exit();
    }

    //Checking character length
    if (strlen($password) < 8 && !empty($password)){
        handleErrorAndRedirect::handleErrorRedirectM("invalid_password_minimum", "Password must have minimum 8 characters", $location);
        $udana_walidacja = false;
        exit();
    }

    if (strlen($password) > 16 && !empty($password)){
        handleErrorAndRedirect::handleErrorRedirectM("invalid_password_maximum", "Password must have maximum 16 characters", $location);
        $udana_walidacja = false;
        exit();
    }


    //Error handling - Password must have at least 8 characters
    if ((strlen($password) < 8 || strlen($password) > 16) && !empty($password)) {
        handleErrorAndRedirect::handleErrorRedirectM("invalid_password", "Password must have minimum 8 characters and maximum 16", $location);
        $udana_walidacja = false;
        exit();
    }

    //Checking if password contain at least one small and big letter, two numbers, and two special characters
    $ValidateSpecialCharacters_aA11twoSpecial = new ValidateSpecialCharacters_aA11twoSpecial();
    if (!$ValidateSpecialCharacters_aA11twoSpecial->ValidateSpecialCharactersM($password) && !empty($password)) {
        handleErrorAndRedirect::handleErrorRedirectM("invalid_password_characters", "Password must contain at least
        one small and big letter, two numbers, and two special characters", $location);
        $udana_walidacja = false;
        exit();
    }

    //Password must be repeated
    if ($password != $password_repeated && !empty($password_repeated)){
        handleErrorAndRedirect::handleErrorRedirectM("invalid_password_repeated", "Passwords must be repeated", $location);
        $udana_walidacja = false;
        exit();
    }

    //google recaptcha validation
    $secret = '6LcIKz4mAAAAADLpVSoPLkoDWVlF2PJad9L8ekKE';
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='. $_POST['token_response']);

    $response = json_decode($check);
    if ($response->success==false && $response->score < 0.5){
        handleErrorAndRedirect::handleErrorRedirectM("recaptcha_bot", "You may be bot", $location);
        $udana_walidacja = false;
        exit();
    }

    //User has passed trough all the requirements
    if ($udana_walidacja == true) {
        //Password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //Records into database
        $kamien = 100;
        $zboze = 100;
        $drewno = 100;

        //Creating a premium account for 14 days
        $currentDateTime = date('Y-m-d H:i:s');
        $futureDateTime = date('Y-m-d H:i:s', strtotime('+14 days', strtotime($currentDateTime)));

        //Insert records into database
        $databaseQuerry3 = clone $databaseQuerry1;
        $databaseQuerry3->DatabaseQuerryM("INSERT INTO uzytkownicy values (null, '$user', '$hashedPassword', '$email', '$drewno', '$kamien', '$zboze', '$futureDateTime')");
        $_SESSION['registration_successful'] = "Congratulations! You have been registered";
        header("Location:../Login/Login-Form.php");
        exit();
    }

}//The end of code




else{
    header("Location:Registration-form.php");
}