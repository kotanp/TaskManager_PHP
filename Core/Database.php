<?php

namespace App\Core;
use PDO;
use PDOException;

class Database{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $connection;

    function __construct($host, $db_name, $username, $password, $connection)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        if ($connection == '') {
            $this->connection = null;
        }
    }

    public function connect(){
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'Kapcsolódási hiba: ' . $ex->getMessage();
        }

        return $this->connection;
    }
}