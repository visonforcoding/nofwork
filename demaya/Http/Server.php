<?php
namespace demaya\Http;

use demaya\Route\Route;

class Server
{
    public function run()
    {
        $route = new Route();
        $urls = $route->prase();
        $controller = $this->toBigHump($urls[1]);
        $action = $this->toBigHump($urls[2]);
        $controllerClass = 'App\\Controller\\'.$controller;
        $controllerObj = new $controllerClass;
        call_user_func([$controllerObj,$action]);
    }

     /**
     * 字符串变成大驼峰
     * @param type $str	待处理字符串
     * @return string 结果字符串
     */
    public function toBigHump($str)
    {
        $str = strtolower($str);
        $arr = preg_split('/_|-/', $str);
        foreach ($arr as &$value) {
            $value = ucfirst($value);
        }
        return implode('', $arr);
    }
}
