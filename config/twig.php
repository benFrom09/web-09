<?php

use App\Support\RouteParser;
use Slim\App;
use Twig\TwigFunction;

return [

    //'cache' => path/to/cache,
    'view_dir' => views_path(),
    'ext' => '.html.twig',
    'functions' => [
        new TwigFunction('route',[RouteParser::class,'urlFor']),
        new TwigFunction('showValidationErrors','showValidationErrors'),
        new TwigFunction('pageUrl',[RouteParser::class,'pageUrl'])
       
    ]
];