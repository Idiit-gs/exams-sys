<?php
/**
* ORM Manager
* Validates and authenticates user login credentials
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Utils;

class OrmManager {

	private $orm;

	public function getORM() {
		return $this->orm;
	}

	public function setORM($ormObject) {
		$this->orm = $ormObject;
	}
	
}

?>