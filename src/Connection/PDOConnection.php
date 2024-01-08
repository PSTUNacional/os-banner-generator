<?php

namespace Banners\Connection;

/*
*
*   You must import your env vars 
*   require $_SERVER['DOCUMENT_ROOT'] . '';
*
*/

class PDOConnection
{
    private $host;
    private $database;
    private $user;
    private $password;
    private $driver;

    public function __construct()
    {
        $this->host = HOST;
        $this->database = DATABASE;
        $this->user = DBUSER;
        $this->password = DBPASSWORD;
        $this->driver = 'mysql';
    }

    public function connect()
    {
        try {
            $conn = new \PDO(
                "{$this->driver}:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->user,
                $this->password
            );

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
            
        } catch (\PDOException $e) {
            echo '<pre>'.$e;
            die('Não foi possível solicitar a conexão com nossos servidores. Tente novamente.');
        }
    }
}
