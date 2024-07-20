<?php

namespace Core;

class Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    protected function renderView($view, $data = [])
    {
        extract($data);
        $viewPath = "../app/Views/{$view}.php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "View file not found: " . $viewPath;
        } 

        // extract($data);
        // require_once '../app/Views/{view}.php';
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}
