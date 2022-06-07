<?php
namespace App\Providers;

use App\Support\Model;
use App\Support\ServiceProvider;
use PDO;

class PDOServiceProvider extends ServiceProvider
{
    public function register() {

        /*
        $credentials = data_get(config('database.connections'),config('database.default'));
        $pdo_options = data_get(config('database.options'),null);

       
        $db = new PDO("mysql:host=" . $credentials['host'] . ";dbname="
        . $credentials['database'],$credentials['username'],
        $credentials['password'],$pdo_options);

       $this->bind('db',fn() => $db);
       */
      $db = new Model();

      $this->bind('db',fn() => $db::getDb());

    }

    public function boot() {
        //
    }
}