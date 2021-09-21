<?php

namespace App\Lib;

use App\Core\View;

class Router
{
    public static function run(): void
    {
        $controllerName = 'HomeController';
        $actionName = 'indexAction';
        
        $controllerPath = "app\controllers\\{$controllerName}";
        if (class_exists($controllerPath)) {
            if (method_exists($controllerPath, $actionName)) {
                $controller = new $controllerPath();
                $controller->$actionName();
            }
        }
        View::errorCode(404);
    }
}