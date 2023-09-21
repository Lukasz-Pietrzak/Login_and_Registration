<?php

session_start();
//session_unset();

require_once "../Login/Autoloading.php";
Autoloading::autoloader();

//Direct user if he has logged in
if (isset($_SESSION['panel']) && ($_SESSION['panel'] === true)){
    header('Location:../Login/The main panel.php');
    exit();
}

$_SESSION['zapomniane_pasy'] = true;

if (isset($_POST['submit'])){
    $email = $_POST['email'];

        $dbconnection = new DbConnect();
        $dbconnection->DatabaseConnection('localhost', 'root', '', 'osadnicy');

            //Generate new login and password
            $newLoginGenerated = substr(md5(uniqid()), 2, 8);
            $newPasswordGenerated = bin2hex(random_bytes(8));

            $databaseQuerry = new DatabaseQuerry($dbconnection);
            $databaseQuerry->DatabaseQuerryM("SELECT user, pass, email from uzytkownicy WHERE email='$email'");

            //Check if the email exists
                $accessControl = new AccessControl($databaseQuerry);
                $accessControlResult = $accessControl->FetchAccessControlM();

                if ($accessControlResult) {
                    $databaseQuerry2 = clone $databaseQuerry;
                    $passwordHash = password_hash($newPasswordGenerated, PASSWORD_DEFAULT);
                    //if email is correct update login and password
                        $databaseQuerry2->DatabaseQuerryM("UPDATE uzytkownicy set user='$newLoginGenerated', pass='$passwordHash' WHERE email='$email'");

                        //Create sesssion in order to display login and password in another file
                            $_SESSION['nowyLoginiHaslo'] = true;
                            $_SESSION['przypomnienie_login'] = "Twój nowy login to:" . ' ' . $newLoginGenerated . "<br>";
                            $_SESSION['przypomnienie_haslo'] = "Twoje nowe hasło to:" . ' ' . $newPasswordGenerated;
                            header('Location: ../Login/Login-Form.php');

                } else  {
                    handleErrorAndRedirect::handleErrorRedirectM("niepoprawny_adresik", 'Niepoprawny adres email', 'zapomniane_haslo_form.php');
                }


            mysqli_close($dbconnection->getConnection());

}

else{
    header('Location:zapomniane_haslo_form.php');
}



