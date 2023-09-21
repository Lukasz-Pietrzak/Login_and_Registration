<?php
require_once "../Login/Autoloading.php";
Autoloading::autoloader();

class ValidateSpecialCharacters_aA11twoSpecial implements ValidateSpecialCharactersInterface {
    public function ValidateSpecialCharactersM(string $variable){
        $pattern = '/(?=.*\d.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!-*]{2})/';
        return preg_match($pattern, $variable);
    }
}
