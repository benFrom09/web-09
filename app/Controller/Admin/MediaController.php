<?php
namespace App\Controller\Admin;

use App\Support\View;
use App\Support\BaseController;
use Psr\Http\Message\ResponseInterface as Response;

class MediaController extends BaseController
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function index():Response {

        return View::render('admin@pages@admin_media');
    }
}