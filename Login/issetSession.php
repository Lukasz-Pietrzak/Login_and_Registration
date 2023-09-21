<?php

class issetSession{
    public static function issetSessionM(string $sessionName){
        if (isset($_SESSION[$sessionName])){
            echo $_SESSION[$sessionName];
            unset($_SESSION[$sessionName]);
        }
    }
}
