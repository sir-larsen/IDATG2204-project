<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

class DB {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';charset=utf8',
            $_ENV['DB_USER'], $_ENV['DB_PWD'],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    }
}
