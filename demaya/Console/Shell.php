<?php

namespace demaya\Console;

use League\CLImate\CLImate;
use demaya\Service\Dispatch;

class Shell
{

	protected $args;
	/**
	 *
	 * @var CLImate 
	 */
	protected $climate;

	public function __construct($args = [])
	{
		$this->args = $args;
		$this->climate = new CLImate();
		$this->initialize();
	}

	final public static function run($args)
	{
		$shell = new Shell($args);
		$shell->dispatch();
	}

	/**
	 * Initialization hook method.
	 *
	 * Implement this method to avoid having to overwrite
	 * the constructor and call parent.
	 */
	public function initialize()
	{
		
	}

	public function dispatch()
	{
		$args = $this->args;
		if (!isset($args[1]) || !isset($args[2])) {
			$this->climate->error('缺少脚本名或脚本方法参数');
			exit();
		}
		$class = $this->args[1];
		$method = $this->args[2];
		Dispatch::_dispatch($class, $method);
	}

	public function error($msg)
	{
		return $this->climate->error($msg);
	}

	public function info($msg)
	{
		return $this->climate->info($msg);
	}

	public function success($msg)
	{
		return $this->climate->blue($msg);
	}

}
