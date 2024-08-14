<?php

class Connection {
    static public function connect() {
        $host = "localhost";
        $db="pos";
        $userDB="root";
        $passDB="";
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $userDB, $passDB);
            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}