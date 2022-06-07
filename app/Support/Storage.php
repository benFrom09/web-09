<?php
namespace App\Support;


class Storage 
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    public static $storage;

    public static function setUp(string $path) {
       self::$storage = $path;
    }

    public static function getStoragePath() {
        return self::$storage;
    }
}