<?php
declare(strict_types=1);

namespace App\Support;

use Psr\Container\ContainerInterface;
use Slim\App;

abstract class ServiceProvider
{
    /**
     * Undocumented variable
     *
     * @var App
     */
    public App $app;

    /**
     * Undocumented variable
     *
     * @var ContainerInterface
     */
    public ContainerInterface $container;

    /**
     * Undocumented function
     *
     * @param App $app
     */
    public function __construct(App &$app) {
        $this->app = $app;
        $this->container = $app->getContainer();

    }

    abstract public function register();
    abstract public function boot();

    public function bind($key, $callable) {
        $this->container->set($key,$callable);
    }

    public function resolve($key) {
        $this->container->get($key);
    }


    public static function setUp(App &$app, array $providers) {

        $providers = array_map(fn($provider) => new $provider($app),$providers);

        array_walk($providers,fn(ServiceProvider $provider) => $provider->register());
        array_walk($providers,fn(ServiceProvider $provider) => $provider->boot());

    }

}