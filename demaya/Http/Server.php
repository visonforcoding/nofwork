<?php

namespace demaya\Http;

use demaya\Route\Route;
use demaya\Service\Dispatch;
use dmy\Configure\Configure;

class Server
{

	protected $configDir;
	protected $requestUrl;

	public function __construct($configDir)
	{
		$this->configDir = $configDir;
		Configure::configured($this->configDir);
	}

	public function run()
	{
		$this->bootstrap();
		$this->dispatch();
	}

	public function bootstrap()
	{
		require $this->configDir . '/bootstrap.php';
	}

	protected function dispatch()
	{
		require $this->configDir . '/routes.php';
		$route = new Route();
		$this->requestUrl = $route->request_url;
		$urls = $route->prase();
		$controller = null;
		$action = null;
		foreach (Route::$routes as $value) {
			if ($this->requestUrl == $value['url']) {
				//匹配路由
				$controller = $value['dispatchParams']['controller'];
				$controller = toBigHump($controller);
				$action = $value['dispatchParams']['action'];
				$action = toLittleHump($action);
				break;
			} else {
				//范路由
				if(preg_match('/^\/:controller/',$value['url'])){
					$controller = toBigHump($urls[1]);
				}
			}
		}
		if (!$controller || !$action) {
			$controller = toBigHump($urls[1]);
			$action = toLittleHump($urls[2]);
		}
		Dispatch::_dispatch($controller, $action);
	}

}
