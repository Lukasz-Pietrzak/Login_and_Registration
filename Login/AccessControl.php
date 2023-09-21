<?php
require_once "Autoloading.php";
Autoloading::autoloader();
class AccessControl
{
    private $databaseQuerry;

    public function __construct(DatabaseQuerry $databaseQuerry)
    {
        $this->databaseQuerry = $databaseQuerry;
    }

    public function FetchAccessControlM()
    {
        $users = mysqli_num_rows($this->databaseQuerry->getResult());
        if ($users > 0) {
            return true;
        } else {
            return false;
        }
    }


}