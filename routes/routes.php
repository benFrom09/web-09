<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use App\Controller\Admin\AdminController;
use App\Controller\Admin\MediaController;
use App\Controller\Admin\PriceController;
use App\Controller\FileAccessController;
use App\Middlewares\AuthMiddleware;
use Psr\Http\Message\ServerRequestInterface;


return function (App $app) {
   //serve files
   $app->get('/file/serve/{file}',[FileAccessController::class,'serve'])->setName('serve.file');

   $app->group('/web-admin', function(RouteCollectorProxy $group) {
      
      $group->get('',[AdminController::class,'index'])->setName('admin.index');
      $group->get('/prices',[PriceController::class,'get'])->setName('admin.prices');
      $group->get('/prices/edit/{id}',[PriceController::class,'edit'])->setName('admin.prices.edit');
      $group->post('/prices/update/{id}',[PriceController::class,'update'])->setName('admin.prices.update');
      $group->post('/prices/delete/{id}',[PriceController::class,'delete'])->setName('admin.prices.delete');
      $group->get('/prices/create',[PriceController::class,'showCreateForm'])->setName('admin.prices.showCreateForm');
      $group->post('/prices/create',[PriceController::class,'create'])->setName('admin.prices.create');
     
      $group->get('/media',[MediaController::class,'index'])->setName('admin.media');

   })->add(new AuthMiddleware);
   
   
   
   $app->get('/api/prices',[PriceController::class,'index']);

   $app->get('/api/prices/edit',function(ServerRequestInterface $request,ResponseInterface $response) use ($app) {
      
   });

   $app->get('/api/prices/create',function(ServerRequestInterface $request,ResponseInterface $response) use ($app) {
      
   });
};