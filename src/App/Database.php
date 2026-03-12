<?php

declare(strict_types = 1);

namespace App;

use PDO;

class Database {

    private $host;
    private $name;
    private $user;
    private $password;

    public function __construct(string $host, string $name, string $user, string $password) {

        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->password = $password;
    }

    public function getConnection(): PDO {

        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8;port=3306";

        return new PDO($dsn, $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
}