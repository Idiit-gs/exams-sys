<?php
/**
* ORM
* Database Handler.
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 2/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\DB;

use Plug\Framework\DBAL\QueryBuilder\QueryBuilder as QueryBuilder;
use Plug\Framework\DBAL\Connection\Query as Query;

class ORM {
	private $queryBuilder;
	private $db_location;

	public function __construct() {
		//connect to db
		$this->db_location = $_SERVER["DOCUMENT_ROOT"]."/temp/data.db";
		$this->queryBuilder = new QueryBuilder();
	}

	public function getPassword($user) {
		$queryBuilder = $this->queryBuilder;
		$query_string = $queryBuilder
							->select("password")
							->from("users")
							->where("username = '$user'")
							->build();
		$query = new Query($query_string, $this->db_location);

		return $query->result();
	}
}

?>