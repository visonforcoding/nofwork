<?php

namespace demaya\Http;

use demaya\Route\Route;
use demaya\Service\Dispatch;

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

	public function bootstrap()
	{
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
				$controller = toBigHump($controller);
				$action = $value['dispatchParams']['action'];
				$action = toLittleHump($action);
				break;
			}
		}
		if (!$controller || !$action) {
			$controller = toBigHump($urls[1]);
			$action = toLittleHump($urls[2]);
		}
		Dispatch::_dispatch($controller, $action);
	}

}
