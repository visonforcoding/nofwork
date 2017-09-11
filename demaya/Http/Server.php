<?php
namespace demaya\Http;

use demaya\Route\Route;

class Server
{
    protected $configDir;
    public function __construct($configDir)
    {
        $this->configDir = $configDir;
    }
    public function run()
    {
        $this->bootstrap();
        $this->dispatch();
    }

    public function bootstrap(){
        require $this->configDir . '/bootstrap.php';
    }


    protected function dispatch()
    {
        require $this->configDir . '/routes.php';
        $route = new Route();
        $url = $route->request_url;
        $urls = $route->prase();
        $controller = null;
        $action = null;
        foreach (Route::$routes as $value) {
            if ($url == $value['url']) {
                $controller = $value['dispatchParams']['controller'];
                $controller = $this->toBigHump($controller);
                $action = $value['dispatchParams']['action'];
                $action = $this->toLittleHump($action);
                break;
            }
        }
        if (!$controller || !$action) {
            $controller = $this->toBigHump($urls[1]);
            $action = $this->toLittleHump($urls[2]);
        }
        $controllerClass = 'App\\Controller\\' . $controller;
        if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
            header("HTTP/1.0 404 Not Found");
            echo "404 not found {$controllerClass} {$action}";
            exit();
        }
        $controllerObj = new $controllerClass;
        call_user_func([$controllerObj, $action]);
    }

    /**
     * 字符串变成大驼峰
     * @param string $str	待处理字符串
     * @return string 结果字符串
     */
    protected function toBigHump($str)
    {
        $str = strtolower($str);
        $arr = preg_split('/_|-/', $str);
        foreach ($arr as &$value) {
            $value = ucfirst($value);
        }
        return implode('', $arr);
    }

    /**
     * 字符串变成小驼峰
     * @param string $str	待处理字符串
     * @return string		结果字符串
     */
    public function toLittleHump($str)
    {
        $str = strtolower($str);
        $arr = preg_split('/_|-/', $str);
        $isFirst = true;
        foreach ($arr as &$value) {
            if ($isFirst) {
                $isFirst = false;
                $value = lcfirst($value);
            }
            else {
                $value = ucfirst($value);
            }
        }
        return implode('', $arr);
    }
}
