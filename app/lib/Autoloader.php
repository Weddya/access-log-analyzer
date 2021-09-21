<?php

namespace App\Lib;

class Autoloader
{
    public static function run(): void
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}