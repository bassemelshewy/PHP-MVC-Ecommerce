<?php
class Database{

    private $host = 'localhost';
    private $dbName = 'p-ecommerce';
    private $username = 'root';
    private $password = '';
    public $connection;

    public function __construct(){
        try {
            $this->connection = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->dbName
            );
        } catch (Exception $e) {
            die("Could not connect to database: ". $e->getMessage());
        }

    }

    public function getConnection(){
        return $this->connection;
    }

}