<?php
namespace App\Support;

use PDO;
use Slim\App;



class Model 
{
    private static $instance = null;

    private static $conn;

    public function __construct() {
        $credentials = data_get(config('database.connections'),config('database.default'));
        $pdo_options = data_get(config('database.options'),null);
        self::$conn = new PDO("mysql:host=" . $credentials['host'] . ";dbname="
        . $credentials['database'],$credentials['username'],
        $credentials['password'],$pdo_options);
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public static function getDb() {
        return self::$conn;
    }
    
}