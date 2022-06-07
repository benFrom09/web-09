<?php
namespace App\Providers;

use App\Support\View;
use App\Support\ServiceProvider;
use Slim\Psr7\Factory\ResponseFactory;

class ViewServiceProvider extends ServiceProvider
{
    public function register() {

        View::setUp(new ResponseFactory,config('twig.functions'));
    }

    public function boot() {
        //
    }
}