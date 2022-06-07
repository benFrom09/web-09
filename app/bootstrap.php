<?php

use App\Support\Session;
use DI\Bridge\Slim\Bridge;
use App\Support\RouteParser;
use App\Support\ServiceProvider;

require __DIR__ . '/../vendor/autoload.php';

$providers = config('app.providers');

$container = new DI\Container();

$app = Bridge::create($container);

$session = new Session();

$session->set('auth',1);

ServiceProvider::setUp($app,$providers);

$app->addErrorMiddleware(true,true,true);


$routes = require __DIR__ . '/../routes/routes.php';

$routes($app);


$routes = require __DIR__ . '/../routes/routes.php';

$app->addRoutingMiddleware();

new RouteParser($app);

return $app;