<?php

namespace App\Shell;

use demaya\Console\Shell;

class LogClient extends Shell
{

	protected $addr = '127.0.0.1';
	protected $port = 10000;

	public function start()
	{
		if (($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) == FALSE) {
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			$this->error("创建socekt失败: [$errorcode] $errormsg");
		}
		$this->success('socket 创建成功...');

		//Do some communication, this loop can handle multiple clients
		while (true) {
			$input = $this->climate->input('Enter a message to send :');
			$input = $input->prompt();
			//Send the message to the server
			if (!socket_sendto($socket, $input, strlen($input), 0, $this->addr, $this->port)) {
				$errorcode = socket_last_error();
				$errormsg = socket_strerror($errorcode);
				$this->error("Could not send data: [$errorcode] $errormsg \n");
			}
			//Now receive reply from server and print it
			if (socket_recv($socket, $reply, 2045, MSG_WAITALL) === FALSE) {
				$errorcode = socket_last_error();
				$errormsg = socket_strerror($errorcode);
				$this->error("Could not receive data: [$errorcode] $errormsg \n");
			}

			$this->info("Reply : $reply");
		}
		socket_close($socket);
	}

}
