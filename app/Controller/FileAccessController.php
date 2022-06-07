<?php
namespace App\Controller;

use App\Support\Storage;
use App\Support\BaseController;

class FileAccessController extends BaseController
{
    public function serve($file) {

        $filePath = Storage::getStoragePath();
    }
}