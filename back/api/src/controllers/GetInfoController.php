<?php
/**
* Lecturer Get Info Controller
* Process a get request for lecturer info
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 10/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Request;

use Examsys\Api\Utils\ParamHandler;
use Examsys\Api\Utils\Messages;
use Examsys\Api\Utils\ApiInterface as ApiInterface;

class GetInfoController {
	protected $db;

	public function __construct(\Examsys\Api\Utils\OrmManager $ormManager = null) {
		if ($ormManager != null) {
			$this->db = $ormManager->getORM();
		}
	}

	public function convertUserTypeToId($user_type) {
		$user_type_info = $this->db->getUserType("name like '$user_type'");	
		if (isset($user_type_info["result"][0])){
			$user_type = $user_type_info["result"][0]["id"];
		}
		else {
			$user_type = null;
		}
		return $user_type;
	}

	public function getUserInfo($user_type, $user_id) {
		$request_checker = $this->db->getUser("user_type = $user_type AND id = $user_id");

		if (!isset($request_checker["result"][0])) {
			return null;
		}

		$user_info_id = $request_checker["result"][0]["user_info"];

		$user_info = $this->db->getUserInfo("id = $user_info_id");

		if (!isset($user_info["result"][0])) {
			$user_info = false;
		}

		return $user_info;
	}


}

?>