<?php

class Model {

    public function getData() {
        $dsn = "mysql:host=localhost;dbname=product_db;charset=utf8;port=3306";

        $pdo = new PDO($dsn, "product_db_user", "secret", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $stmt = $pdo->query("SELECT * FROM product");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}