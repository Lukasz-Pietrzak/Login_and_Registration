<?php

interface DBConnectionInterface{

    /**
     * @param string $localhost
     * @param string $username
     * @param string $password
     * @param string $database
     * @return void
     */
    public function DatabaseConnection(string $localhost, string $username, string $password, string $database):void;

}