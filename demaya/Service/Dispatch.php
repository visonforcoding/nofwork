<?php

namespace demaya\Service;

class Dispatch
{

	public static function _dispatch($class, $action)
	{
		$class = toBigHump($class);
		$action = toLittleHump($action);
		if (php_sapi_name() == 'cli') {
			$controllerClass = 'App\\Shell\\' . $class;
		} else {
			$controllerClass = 'App\\Controller\\' . $class;
			if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
				header("HTTP/1.0 404 Not Found");
				echo "404 not found {$controllerClass} {$action}";
				exit();
			}
		}
		$controllerObj = new $controllerClass;
		call_user_func([$controllerObj, $action]);
	}

}
