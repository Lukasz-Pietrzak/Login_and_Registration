<?php

session_start();
require_once "Autoloading.php";
Autoloading::autoloader();

if ($_POST['submit']){

    //Redirect if empty field
    if (empty($_POST['tekst']) || empty($_POST['password'])) {
        if (empty($_POST['tekst'])) {
            handleErrorAndRedirect::handleErrorRedirectM('empty_tekst', 'Login cannot be empty', "Login-Form.php");
        }
        if (empty($_POST['password'])) {
            handleErrorAndRedirect::handleErrorRedirectM('empty_password', 'Password cannot be empty', "Login-Form.php");
        }
        exit();
    }



    $sqlConnection = new DbConnect();
    $sqlConnection->DatabaseConnection('localhost', 'root','', 'osadnicy');


    $databaseQuerry = new DatabaseQuerry($sqlConnection);
    $login = $_POST['tekst'];
    $password = $_POST['password'];

    $loginProtect = mysqli_real_escape_string($sqlConnection->getConnection(), $login);

    $query = sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
        $loginProtect);

    $databaseQuerry->DatabaseQuerryM($query);



    //Responsible for saving sessions
    $sessions = ['user', 'pass', 'email', 'drewno', 'kamien', 'zboze', 'dnipremium'];


    //Check if user entered correct login and password
    $AccesControl = new AccessControl($databaseQuerry);
    if ($AccesControl->FetchAccessControlM()) {
        $record = mysqli_fetch_assoc($databaseQuerry->getResult());
        if (password_verify($password, $record['pass'])) {
            $_SESSION['zalogowany'] = true;

            //Save sessions in order to display them user, which has logged in successfully
            $fetchRecord = new FetchRecord();
            $fetchRecord->session($sessions, $record);

            header("Location:The main panel.php");
        } else {
            handleErrorAndRedirect::handleErrorRedirectM('niezalogowany', 'Błędny login lub hasło', 'Login-Form.php');
        }
    } else {
        handleErrorAndRedirect::handleErrorRedirectM('niezalogowany', 'Błędny login lub hasło', 'Login-Form.php');
    }


}

else{
    handleErrorAndRedirect::handleErrorRedirectM('niezalogowany','',"Login-Form.php");
    exit();
}

