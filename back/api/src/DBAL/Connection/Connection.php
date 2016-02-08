<?php
/**
 * Connection: Creates a Connection to a database
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 5th January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/

namespace Plug\Framework\DBAL\Connection;

/**
 * @package Plug\Framework\Connection
*/
class Connection
{
	private static $database_handler;
	private static $dsn;
	private static $username;
	private static $password;
	private function __construct()
	{
		/**
		 * @todo Do some singleton-specific-stuff here
		*/
	}

	public static function setDsn($dsn)
	{
		self::$dsn = $dsn;
		return;
	}

	public static function setUsername($username)
	{
		self::$username = $username;
		return;
	}

	public static function setPassword($password)
	{
		self::$password = $password;
		return;
	}
	
	public static function getInstance($dsn = null, $username = null, $password = null)
	{
		if (is_null($dsn) === false) { self::$dsn = $dsn; }

		if (is_null($username) === false) { self::$username = $username; }
		
		if (is_null($password) === false) { self::$password = $password; }

		try
		{
			if (false === is_null(self::$database_handler))
			{
				return self::$database_handler;
			}
			self::$database_handler = new \PDO(self::$dsn, self::$username, self::$password);
			//self::$database_handler->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
			return self::$database_handler;
		}
		catch(\PDOException $pdo_exception)
		{
			throw new \Exception();
			print_r($pdo_exception);
			/**
			 * @todo Do something about this error
			*/
		}
	}

	public static function destroyInstance()
	{
		/**
		 * @todo Properly kill/close the connection
		*/
		self::$database_handler = null;
	}

	private function __clone(){ }
}
?>