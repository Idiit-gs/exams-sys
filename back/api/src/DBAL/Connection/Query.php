<?php
/**
 * Query: Executes a query on a connection object
 *
 * @author Samuel Adeshina <samueladeshina73@gmal.com> <http://samshal.github.io>
 * @version 0.0.1
 * @since version 0.0.1, 12th January 2016
 * @copyright 2016 - Samuel Adeshina <samueladeshina73@gmail.com>
 * @license MIT
*/


namespace Plug\Framework\DBAL\Connection;

use Plug\Framework\DBAL\Connection\Connection as Connection;

/**
 * @package Plug\Framework\Connection
*/
class Query
{
	private $sql_statement_object;
	private $statement_query_object;
	private $database_location;

	public function __construct($sql_statement_object, $database_location)
	{
		$this->sql_statement_object = $sql_statement_object;
		$this->database_location = $database_location;

		if (false !== is_array($sql_statement_object))
		{
			$this->statement_query_object = self::preparedStatementQuery();
		}
		
		if (false !== is_string($sql_statement_object))
		{
			$trimmed_string = trim(rtrim($sql_statement_object, " "), " ");
			$select_substring = substr(strtolower($trimmed_string), 0, 6);
			if ($select_substring == "select")
			{
				$is_select = true;
			}
			else
			{
				$is_select = false;
			}
			$this->statement_query_object = self::normalStatementQuery($is_select);
		}
		else
		{
			/**
			 * @todo We have an issue here. How do we tell the user an invalid object's been injected?
			*/
		}
	}

	private function preparedStatementQuery()
	{
		$sql_query_string = $this->sql_statement_object[0];
		$sql_query_string_params = $this->sql_statement_object[1];

		$prepared_statement = self::getDatabaseConnection()->prepare($sql_query_string);

		foreach ($sql_query_string_params as $individual_param_array)
		{
			$prepared_statement->bindParam($individual_param_array[0], $individual_param_array[1]);
		}

		$prepared_statement->execute();

		return $prepared_statement;
	}

	private function normalStatementQuery($is_select)
	{
		$db_connection = self::getDatabaseConnection();
		if (!$is_select)
		{
			$query_result = $db_connection->exec($this->sql_statement_object);			
		}
		else
		{
			$query_result = $db_connection->query($this->sql_statement_object)->fetchall();
		}
		$error = $db_connection->errorInfo();
		return array($query_result, $error, $db_connection->lastInsertId());
	}

	private function getDatabaseConnection()
	{
		$dsn = "sqlite:$this->database_location";
		$username = "";
		$password = "";

		Connection::setDsn($dsn);
		Connection::setUsername($username);
		Connection::setPassword($password);

		return Connection::getInstance();
	}

	public function result()
	{
		return $this->statement_query_object;
	}
}
?>