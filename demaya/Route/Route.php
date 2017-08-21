<?php
namespace demaya\Route;

class Route
{
    public static $routes = [];

    public function add()
    {
    }

    public function prase(){
        $pathinfo = $_SERVER['PATH_INFO'];
        $paths = explode('/',$pathinfo);
        return $paths;
    }
}
