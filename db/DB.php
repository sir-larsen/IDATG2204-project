<?php
require_once 'dbCredentials.php';
require_once 'controller\APIException.php';

/*require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();*/


/**
 * Class DB root for model - and other - classes needing access to the database
 */
class DB {
    /**
     * @var PDO
     */
    protected $db;

    /*public function __construct() {
        $this->db = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';charset=utf8',
            $_ENV['DB_USER'], $_ENV['DB_PWD'],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }*/
    public function __construct()
    {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
}
