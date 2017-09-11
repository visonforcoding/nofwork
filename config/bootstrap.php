<?php

use Tracy\Debugger;

define('ENV', 'prd');
switch (ENV) {
	case 'dev':
		//tracy debug
		Debugger::enable(Debugger::DEVELOPMENT);
		break;
	case 'prd':
		//引入sentry
//		$client = new Raven_Client('http://52c68a4c4dea446ca9b56318b22160c8:79378f4b5473486780d465f275164158@192.168.33.12:9001/2');
//		$error_handler = new Raven_ErrorHandler($client);
//		$error_handler->registerExceptionHandler();
//		$error_handler->registerErrorHandler();
//		$error_handler->registerShutdownFunction();
		error_reporting(0);
		set_error_handler(function($errno, $errstr, $errfile, $errline) {
			var_dump([
				'errno' => $errno,
				'errstr' => $errstr,
				'errfile' => $errfile,
				'errline' => $errline
			]);
		});
		register_shutdown_function(function() {
			$error = error_get_last();
			var_dump($error);
		});
		break;
	default:
		break;
}