<?php

namespace demaya\Service;

use ReflectionClass;
use demaya\Http\Request;
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
		$reflection = new ReflectionClass($controllerClass);
		if ($reflection->isAbstract() || $reflection->isInterface()) {
			throw new Exception('missing controller');
		}
		$request = Request::createFromGlobals();
		$controllerObj = $reflection->newInstance($request);
		$controllerObj->$action();
//		call_user_func([$controllerObj, $action]);
	}

}
