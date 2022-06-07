<?php
namespace App\Providers;

use Dotenv\Dotenv;
use App\Support\ServiceProvider;

class LoadEnvironmentVariables extends ServiceProvider
{

    public function register() {
       try {
           //code...
            $dotenv = Dotenv::createImmutable(base_path());
            $dotenv->load();
       } catch (\Throwable $th) {
           //throw $th;
       }
        
    }

    public function boot() {

    }
}