<?php

namespace Core;

class Route{
    private static $routes = [];


    public static function get($uri, $action){
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action){
        self::$routes['POST'][$uri] = $action;
    }

    public static function run() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        $baseUri = '/Gestion-Boutique2/public';
        if(strpos($uri, $baseUri) === 0){
            $uri = substr($uri, strlen($baseUri));
        }


        
        if(isset(self::$routes[$method][$uri])){
            $action = self::$routes[$method][$uri];
            list($controller, $method) = $action;
            (new $controller)->$method();
        } 
        else{
            http_response_code(404);
            self::renderView('404');
            // echo "PAGE NOT FOUND";
        }
    }
    
    private static function renderView($view, $data = []){
        extract($data);
        $viewFile = "../app/Views/{$view}.php";
        if(file_exists($viewFile)){
            require_once $viewFile;
        }
        else{
            echo "View file '{$view}.php' not found";
            // require_once "../app/Views/{$view}.php";
        } 
    }
} 
// Debugging output (optional)
// echo "Adjusted URI: " . $uri . "<br>";
// echo "Method: " . $method . "<br>";
// echo "Routes: " . print_r(self::$routes, true) . "<br>";

/*
VERSION AVANT AJOUT RECHERCHE DE CLIENT PAR  TÉLÉPHONE.
class Route{
    private static $routes = [];

    public static function get($uri, $action){
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action){
        self::$routes['POST'][$uri] = $action;
    }

    public static function run() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        $baseUri = '/Gestion-Boutique2/public';
        if(strpos($uri, $baseUri) === 0){
            $uri = substr($uri, strlen($baseUri));
        }


        
        if(isset(self::$routes[$method][$uri])){
            $action = self::$routes[$method][$uri];
            list($controller, $method) = $action;
            (new $controller)->$method();
        } 
        else{
            http_response_code(404);
            self::renderView('404');
            // echo "PAGE NOT FOUND";
        }
    }
    
    private static function renderView($view, $data = []){
        extract($data);
        $viewFile = "../app/Views/{$view}.php";
        if(file_exists($viewFile)){
            require_once $viewFile;
        }
        else{
            echo "View file '{$view}.php' not found";
            // require_once "../app/Views/{$view}.php";
        } 
    }
} 

*/ 