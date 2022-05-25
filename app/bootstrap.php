<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

$app->addErrorMiddleware(true,true,true);


$routes = require __DIR__ . '/../routes/routes.php';

$routes($app);


$routes = require __DIR__ . '/../routes/routes.php';


return $app;