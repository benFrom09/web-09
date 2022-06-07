<?php
namespace App\Support;

use Slim\App;
use Illuminate\Support\Str;
use Slim\Psr7\Factory\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

final class RouteParser {


    public $app;

    public static $routeParser;

    public static $request;


    public function __construct(App &$app) {
        $this->app = $app;
        self::$request = ServerRequestFactory::createFromGlobals();
        self::$routeParser = $app->getRouteCollector()->getRouteParser();
    }

    public static function urlFor($name,array $data = [],array $queryParams = []) {
        $data = $data ?? [];
        $queryParams = $queryParams ?? [];
        return self::$routeParser->urlFor($name,$data,$queryParams);
    }

    /**
     * return the page url 
     */
    public static function pageUrl() {
        $uri = Str::after(self::$request->getUri()->getPath(),'/');
        return $uri;
    }


}