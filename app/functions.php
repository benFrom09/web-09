<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

if(!function_exists('base_path')) {
    /**
     * return base_path
     *
     * @param string $path
     * @return string
     */
    function base_path(string $path = ''):string {
         return dirname(__DIR__) . "/{$path}";
    }
}

if(!function_exists('config_path')) {
    /**
     * return path of config file
     *
     * @param string $path
     * @return void
     */
    function config_path(string $path = '') {
        return base_path("config/{$path}");
    }
}

if(!function_exists('views_path')) {
    function views_path(string $path = '') {

        return base_path("views/{$path}");

    }
}

if(!function_exists('error')) {
    /**
     * throw an exception if doesnt match criteria
     *
     * @param boolean $fails
     * @param string $message
     * @param [type] $exception
     * @return void
     */
    function error(bool $fails,string $message, string $exception = Exception::class) {
        if(!$fails) return;

        throw new $exception($message);
    }
}

if(!function_exists('config')) {
    function config($path = null) {

        $target = [];
        $folder = scandir(config_path(''));
        $files = array_slice($folder,2,count($folder));
        
        foreach ($files as $file) {
            error(Str::after($file,'.') !== 'php', $file . 'must be a php file');

            data_set($target,Str::before($file,'.'),require config_path($file));
        }

        return data_get($target,$path);
       
    }
}

if (!function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed  $target
     * @param  string|array|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        while (!is_null($segment = array_shift($key))) {
            if ($segment === '*') {
                if ($target instanceof Collection) {
                    $target = $target->all();
                } elseif (!is_array($target)) {
                    return value($default);
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = data_get($item, $key);
                }

                return in_array('*', $key) ? Arr::collapse($result) : $result;
            }

            if (Arr::accessible($target) && Arr::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }

        return $target;
    }
}

if (!function_exists('data_set')) {
    /**
     * Set an item on an array or object using dot notation.
     *
     * @param  mixed  $target
     * @param  string|array  $key
     * @param  mixed  $value
     * @param  bool  $overwrite
     * @return mixed
     */
    function data_set(&$target, $key, $value, $overwrite = true)
    {
        $segments = is_array($key) ? $key : explode('.', $key);

        if (($segment = array_shift($segments)) === '*') {
            if (!Arr::accessible($target)) {
                $target = [];
            }

            if ($segments) {
                foreach ($target as &$inner) {
                    data_set($inner, $segments, $value, $overwrite);
                }
            } elseif ($overwrite) {
                foreach ($target as &$inner) {
                    $inner = $value;
                }
            }
        } elseif (Arr::accessible($target)) {
            if ($segments) {
                if (!Arr::exists($target, $segment)) {
                    $target[$segment] = [];
                }

                data_set($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite || !Arr::exists($target, $segment)) {
                $target[$segment] = $value;
            }
        } elseif (is_object($target)) {
            if ($segments) {
                if (!isset($target->{$segment})) {
                    $target->{$segment} = [];
                }

                data_set($target->{$segment}, $segments, $value, $overwrite);
            } elseif ($overwrite || !isset($target->{$segment})) {
                $target->{$segment} = $value;
            }
        } else {
            $target = [];

            if ($segments) {
                data_set($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite) {
                $target[$segment] = $value;
            }
        }

        return $target;
    }
}

if (!function_exists('d')) {
    /**
     * dump and die
     *
     * @return void
     */
    function d()
    {
        array_map(function ($content) {
            echo "<pre>";
            var_dump($content);
            echo "</pre>";
            echo "<hr>";
        }, func_get_args());

        die;
    }
}

if(!function_exists('environment')) {

    function environment(string $key,$default = false) {
        if(array_key_exists($key,$_ENV)) {
            if($_ENV[$key] === '' && $default) {
                $_ENV[$key] = $default;
            }
            $value = $_ENV[$key];     
            error(!$value && !$default,"{$key} is not a defined env variable and has no default value");
           return $value ?? $default;
        } 
    }
}

if(!function_exists('showValidationErrors')) {
    function showValidationErrors() {
        if(!empty($_SESSION['errors'])) {
            ?>
                <div class="alert-danger">
                    <ul>
                        <?php
                        foreach($_SESSION['errors'] as $key => $value): 
                            foreach ($value as $key => $error): ?>    
                                <li><?= $error;?></li>
                            <?php endforeach; 
                        endforeach;
                        unset($_SESSION['errors']);
                         ?>
                    </ul>
                </div>
            <?php
        }
    }
}
