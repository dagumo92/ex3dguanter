<?php
class Connection {
    protected $pdo;

    public function __construct() {
        $config = json_decode(file_get_contents("conf.json"), true);
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
        $this->pdo = new PDO($dsn, $config['user'], $config['password']);
    }
}