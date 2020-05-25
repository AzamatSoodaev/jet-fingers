<?php

class Database
{
    private $DB_HOST = 'localhost';
    private $DB_NAME = 'jet_fingers';
    private $DB_USER = 'root';
    private $DB_PASSWORD = '';
    private $pdo;
    
    public function __construct($DB_HOST, $DB_NAME, $DB_USER, $DB_PASSWORD)
    {
        $this->DB_HOST     = $DB_HOST;
        $this->DB_NAME     = $DB_NAME;
        $this->DB_USER     = $DB_USER;
        $this->DB_PASSWORD = $DB_PASSWORD;
    }
    
    public function __destruct()
    {
        // close the database connection
        $this->pdo = null;
    }
    
    public function getConnection()
    {
        $this->pdo = null;
        
        $conStr = sprintf("mysql:host=%s;dbname=%s", $this->DB_HOST, $this->DB_NAME);
        
        try {
            $this->pdo = new PDO($conStr, $this->DB_USER, $this->DB_PASSWORD);
            // Set the PDO error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        
        return $this->pdo;
    }
}