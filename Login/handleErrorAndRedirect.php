<?php


class handleErrorAndRedirect{
    public static function handleErrorRedirectM(string $sessionName, string $errorMessage, string $location): void
    {
        $_SESSION["$sessionName"] = "<div><span style='color: red'>$errorMessage</span></div>";
        header("Location: $location");
    }
}