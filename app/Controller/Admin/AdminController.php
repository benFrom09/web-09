<?php
namespace App\Controller\Admin;

use App\Model\Price;
use App\Support\View;
use App\Support\BaseController;
use App\Support\RouteParser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends BaseController
{

    public function index(ResponseInterface $response):ResponseInterface {
        return View::render('admin@pages@admin_index');
    }

}