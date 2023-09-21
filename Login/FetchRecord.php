<?php
session_start();
class FetchRecord{

    public function session(array $sessions, $record){
        foreach ($sessions as $session) {
            $_SESSION[$session] = $record[$session];
        }
    }
}
