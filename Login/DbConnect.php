<?php

require_once "Autoloading.php";
Autoloading::autoloader();
class DbConnect implements DBConnectionInterface{
    private $connection;
    public function DatabaseConnection(string $localhost, string $username, string $password, string $database): void
    {
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $this->connection = @new mysqli($localhost, $username, $password, $database);
            if (!$this->connection) {
                throw new mysqli_sql_exception((string)
                mysqli_connect_errno());
            }
        }

        catch (mysqli_sql_exception $e) {
            ErrorLogger::logError($e->getMessage(), 'C:\xampp\error\error.txt');
            echo "Error connecting";
            exit();
        }

    }

    public function getConnection(){
        return $this->connection;
    }
}

$dbConnect = new DbConnect();
$dbConnect->DatabaseConnection('localhost','root', '', 'osadnicy');