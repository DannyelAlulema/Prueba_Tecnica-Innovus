<?php

namespace Core;
use PDO;
use PDOException;

class DBConnection
{
    use Responser;

    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $host = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $database = DB_DATABASE;

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->errorResponse("Error al conectar a la base de datos: " . $e->getMessage(), 500);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DBConnection();
        }

        return self::$instance;
    }


    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql)
    {
        return $this->connection->query($sql);
    }
}