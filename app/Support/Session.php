<?php
namespace App\Support;

class Session 
{
    /**
     * Undocumented variable
     *
     * @var [bool]
     */
    protected $started;

    public function __construct() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
     }


     public function get(string $key) {
        if(array_key_exists($key,$_SESSION)) {
            return $_SESSION[$key];
        }
        return NULL;
    }

    public function all() {
        return $_SESSION;
    }

    public function set(string $key,$value) {
        $_SESSION[$key] = $value;
        return $_SESSION;
    }

    public function unset(string $key) {
        unset($_SESSION[$key]);
        return $key;
    }
}
