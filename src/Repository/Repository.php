<?php

namespace Banners\Repository;

use Banners\Connection\PDOConnection;

abstract class Repository
{
    protected $conn;

    public function __construct()
    {
        $this->conn = new PDOConnection;
        $this->conn = $this->conn->connect();
    }

}
