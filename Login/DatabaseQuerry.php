<?php

require_once "Autoloading.php";
Autoloading::autoloader();
class DatabaseQuerry{
    private $result;
    private $dbConnect;

    public function __construct(DbConnect $dbConnect){
        $this->dbConnect = $dbConnect;
    }
    public function DatabaseQuerryM(string $sql): void
    {

        try {
            $this->result = @mysqli_query($this->dbConnect->getConnection(), $sql);
            if (!$this->result)  {
                throw new Exception(mysqli_error($this->dbConnect->getConnection()));
            }
        } catch (Exception $e) {
            ErrorLogger::logError($e->getMessage(), 'C:\xampp\error\error.txt');
            echo "Błędne zapytanie SQL <br>";
            exit();
        }
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}