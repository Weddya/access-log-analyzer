<?php

require_once './app/lib/Autoloader.php';

use App\Lib\Autoloader;
use App\Lib\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);

Autoloader::run();
Router::run();