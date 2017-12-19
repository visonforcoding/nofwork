<?php

use Tracy\Debugger;
use dmy\logger\Log;
use dmy\Configure\Configure;
use dmy\Datasource\ConnectionManager;

define('ENV', 'dev');

//引入helper function
define('DEMAYA_DIR', dirname(__DIR__) . '/demaya/');
require_once DEMAYA_DIR . 'Helpers/function.php';

require __DIR__ . '/paths.php';

switch (ENV) {
    case 'dev':
        //tracy debug
        Debugger::enable(Debugger::DEVELOPMENT);
        Debugger::$strictMode = false;
        break;
    case 'prd':
        //引入sentry
//		$client = new Raven_Client('http://52c68a4c4dea446ca9b56318b22160c8:79378f4b5473486780d465f275164158@192.168.33.12:9001/2');
//		$error_handler = new Raven_ErrorHandler($client);
//		$error_handler->registerExceptionHandler();
//		$error_handler->registerErrorHandler();
//		$error_handler->registerShutdownFunction();
        error_reporting(0);
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            $error = [
                'errno' => $errno,
                'errstr' => $errstr,
                'errfile' => $errfile,
                'errline' => $errline
            ];
            var_dump($error);
            Log::add('error', '错误', $error);
        });
        register_shutdown_function(function () {
            file_put_contents(time() . 'test.log', time());

            $error = error_get_last();
            if ($error && $error['type'] === E_ERROR) {
                //致命错误捕获
                var_dump($error);
            }
            Log::add('error', '致命错误', $error);
            $dmylog = new Log('127.0.0.1/10000', 'hll-demaya');
            $dmylog->save();
            dump($dmylog);
        });
        break;
    default:
        break;
}
//引入配置
Configure::load('app');
ConnectionManager::config(Configure::consume('Datasources'));
dump(ConnectionManager::get('default'));
