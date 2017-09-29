<?php

namespace dmy\logger;

class Log
{

	protected static $storage = [];
	protected $appId;
	protected $server;
	protected $port;

	public function __construct($dsn, $appId)
	{
		$serverInfo = explode('/', $dsn);
		$server = $serverInfo[0];
		$port = $serverInfo[1];
		$this->server = $server;
		$this->port = $port;
	}

	public static function add($level, string $msg, array $data)
	{
		$content = [
			'level' => $level,
			'msg' => $msg,
			'data' => $data
		];
		array_push(self::$storage, json_encode($content));
	}

	public function save()
	{
		if (($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) == FALSE) {
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			throw new Exception("创建socekt失败: [$errorcode] $errormsg");
		}
		$input = self::$storage;
		$input = json_encode($input);
		if (!socket_sendto($socket, $input, strlen($input), 0, $this->server, $this->port)) {
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			throw new Exception("Could not send data: [$errorcode] $errormsg \n");
		}
		socket_close($socket);
	}

}
