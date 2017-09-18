<?php

define('APP_ROOT', dirname(__DIR__));
$loader = require APP_ROOT . '/vendor/autoload.php';

use League\CLImate\CLImate;

$addr = my_ip();
echo "my ip address is $addr\n";

function my_ip($dest = '64.0.0.0', $port = 80)
{
	$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	socket_connect($socket, $dest, $port);
	socket_getsockname($socket, $addr, $port);
	socket_close($socket);
	return $addr;
}
$Climate = new CLImate();

if (($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) == FALSE) {
	$errorcode = socket_last_error();
	$errormsg = socket_strerror($errorcode);
	$Climate->error("创建socekt失败: [$errorcode] $errormsg");
}
$Climate->blue('socket 创建成功...');

//Do some communication, this loop can handle multiple clients
//$input = $Climate->input('Enter a message to send :');
//$input = $input->prompt();
$msg = [];
while (TRUE) {
	sleep(1);
	$faker = Faker\Factory::create('zh_CN');
	$input = $faker->address;
	$newMsg = [
		'data' => $input,
	];
//	array_push($msg, $newMsg);
	$msgString = json_encode($newMsg);
	//Send the message to the server
	if (!socket_sendto($socket, $msgString, strlen($msgString), 0, '127.0.0.1', 10000)) {
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		$Climate->error("Could not send data: [$errorcode] $errormsg \n");
	}
	//Now receive reply from server and print it
	if (socket_recv($socket, $reply, 2045, MSG_WAITALL) === FALSE) {
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		$Climate->error("Could not receive data: [$errorcode] $errormsg \n");
	}

	$Climate->info("Reply : $reply");
}
socket_close($socket);
