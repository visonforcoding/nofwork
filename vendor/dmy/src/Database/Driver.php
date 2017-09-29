<?php

namespace dmy\Database;

use PDO;

/**
 * Represents a database diver containing all specificities for
 * a database engine including its SQL dialect
 */
abstract class Driver
{

	/**
	 * Configuration data.
	 *
	 * @var array
	 */
	protected $_config;

	/**
	 * Base configuration that is merged into the user
	 * supplied configuration data.
	 *
	 * @var array
	 */
	protected $_baseConfig = [];

	/**
	 * Indicates whether or not the driver is doing automatic identifier quoting
	 * for all queries
	 *
	 * @var bool
	 */
	protected $_autoQuoting = false;
	
	protected $_connection;

	/**
	 * Constructor
	 *
	 * @param array $config The configuration for the driver.
	 * @throws \InvalidArgumentException
	 */
	public function __construct($config = [])
	{
		$config += $this->_baseConfig;
		$this->_config = $config;
		if (!empty($config['quoteIdentifiers'])) {
			$this->autoQuoting(true);
		}
	}

	/**
	 * Establishes a connection to the database server
	 *
	 * @return bool true con success
	 */
	abstract public function connect();

	/**
	 * Disconnects from database server
	 *
	 * @return void
	 */
	abstract public function disconnect();

	/**
	 * Returns correct connection resource or object that is internally used
	 * If first argument is passed,
	 *
	 * @param null|\PDO $connection The connection object
	 * @return void
	 */
	abstract public function connection($connection = null);

	/**
	 * Returns whether php is able to use this driver for connecting to database
	 *
	 * @return bool true if it is valid to use this driver
	 */
	abstract public function enabled();

	/**
	 * Destructor
	 */
	public function __destruct()
	{
		$this->_connection = null;
	}

	/**
	 * Returns an array that can be used to describe the internal state of this
	 * object.
	 *
	 * @return array
	 */
	public function __debugInfo()
	{
		return [
			'connected' => $this->isConnected()
		];
	}

}
