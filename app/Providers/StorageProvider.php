<?php
namespace App\Providers;

use App\Support\ServiceProvider;
use App\Support\Storage;

class StorageProvider extends ServiceProvider
{
    public function register() {

        Storage::setUp(config('app.storage'));
    }

    public function boot() {
        //
    }
}