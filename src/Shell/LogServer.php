<?php

namespace App\Shell;

use demaya\Console\Shell;

class LogServer extends Shell
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

		// 绑定到 ip 端口
		if (!socket_bind($socket, $this->addr, $this->port)) {
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			$this->error("bind socket失败: [$errorcode] $errormsg");
		}
		$this->success('socket bind成功...');
		//Do some communication, this loop can handle multiple clients
		while (true) {
			$this->info("Waiting for data ... \n");
			//Receive some data
			$r = socket_recvfrom($socket, $buf, 65535, 0, $remote_ip, $remote_port);
			$this->info("$remote_ip : $remote_port -- " . var_export(json_decode($buf)));
			//Send back the data to the client
			socket_sendto($socket, "OK " . $buf, 100, 0, $remote_ip, $remote_port);
		}
		socket_close($socket);
	}

	public function test()
	{
		$data = [
			[
				'name' => 'Walter White',
				'role' => 'Father',
				'profession' => 'Teacher',
			],
			[
				'name' => 'Skyler White',
				'role' => 'Mother',
				'profession' => 'Accountant',
			],
			[
				'name' => 'Walter White Jr.',
				'role' => 'Son',
				'profession' => 'Student',
			],
		];
		$input = $this->climate->input('How you doin?');

		$response = $input->prompt();
		var_dump($response);
		$this->climate->table($data);
	}

}
