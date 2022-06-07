<?php
namespace App\Support;
use Slim\App;


class BaseController
{

    /**
     * Slim\App reference instance
     *
     * @var App
     */
    protected $app;

    /**
     * Undocumented variable
     *
     * @var Session
     */
    protected $session;

    public function __construct(App &$app,Session &$session) {
        
        $this->app = $app;
        $this->session = $session;
    }


}