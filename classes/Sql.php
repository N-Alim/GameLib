<?php

class Sql
{
    protected PDO /*object*/ $conn;

    public function __construct($serverName, $database, $userName, $userPassword)
    {
        try
        {
            $this->conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
        }

        catch (PDOException $e)
        {
            $this->conn->rollBack();
    
            die("Erreur : " . $e->getMessage());
        }
    }

    public function insert($sql)
    {
        try
        {
            $this->conn->beginTransaction();
            $this->conn->exec($sql);
            $this->conn->commit();
        }

        catch (PDOException $e)
        {
            $this->conn->rollBack();
    
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        unset($this->conn);
    }
}