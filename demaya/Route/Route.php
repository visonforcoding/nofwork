<?php

namespace demaya\Route;

class Route
{

	public static $routes = [];
	public $request_url;

	public function __construct()
	{
		$this->request_url = $_SERVER['REQUEST_URI'];
	}

	public static function add($url, $dispatchParams = [])
	{
		\array_push(self::$routes, ['url' => $url, 'dispatchParams' => $dispatchParams]);
	}

	public function prase()
	{
		$pathinfo = $_SERVER['PATH_INFO'];
		$paths = explode('/', $pathinfo);
		return $paths;
	}

}
