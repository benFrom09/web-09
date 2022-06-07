<?php

use App\Providers\StorageProvider;
use App\Providers\ViewServiceProvider;

return [

    'name' => environment('SITE_NAME','starter'),
    'locale' => environment('SITE_LOCALE'),
    'storage' => dirname(__DIR__) . '/storage',
    /**
     * Array of service provider
     */
    'providers' => [
         \App\Providers\LoadEnvironmentVariables::class,
         \App\Providers\PDOServiceProvider::class,
         StorageProvider::class,
         ViewServiceProvider::class,
         
    ],
    
    
];