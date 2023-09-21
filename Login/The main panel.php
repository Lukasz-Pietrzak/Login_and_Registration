<?php
session_start();
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    $_SESSION['panel'] = true;
    //Display all the information about user's account
    echo "Witaj" . ' ' . $_SESSION['user'] . '!' . "<a href='Logout.php'>Wyloguj się</a>" . '<br>';
    echo "Twój adres email to:" . ' ' . $_SESSION['email'] . '<br>';
    echo "<b>Drewno:</b>" . $_SESSION['drewno'] . ' ' . "<b>Kamień:</b>" . $_SESSION['kamien'] . ' ' .
        "<b>Zboże:</b>" . $_SESSION['zboze'] . '<br>';


    $currentDataTime = new DateTime();
    $futureDateTime = $currentDataTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);
    $diff = $currentDataTime->diff($futureDateTime);

    if ($diff->invert == 0) {
        echo "Your subscription will be cancelled for: " . ' ' . $diff->format('%d days %h hour %i minute %s second');
    }else{
        echo "Your premium account has ben cancelled, please refresh your subscription";
    }

}
else{
    header("Location:Login-Form.php");
}

