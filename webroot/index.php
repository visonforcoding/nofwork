<?php

/**
 * The Front Controller for handling every request
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 */
// for built-in server
define('APP_ROOT', dirname(__DIR__));
$loader = require APP_ROOT . '/vendor/autoload.php';
$Server = new demaya\Http\Server(dirname(__DIR__).'/config');
$Server->run();