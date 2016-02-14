<?php
/**
* Edit Info Controller
* Process a put request for lecturer info edit
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
use Examsys\Api\Utils\ApiInterface;

class EditInfoController {
	protected $db;
	private $giController;

	public function __construct(\Examsys\Api\Utils\OrmManager $ormManager = null) {
		if ($ormManager != null) {
			$this->db = $ormManager->getORM();
		}
		$this->giController = new GetInfoController($ormManager);
	}

	public function isRequestValid($variables) {
		$user_type = $this->giController->convertUserTypeToId($variables[0]);
		if (is_null($user_type)) {
			return null;
		}

		$user_info = $this->giController->getUserInfo($user_type, $variables[1]);

		if (is_null($user_info)) {
			return null;
		} else if ($user_info === false) {
			return null;
		}

		return true;
	}

	public function editUserInfo($id, $type, $record, $value) {
		$id = $this->giController->getUserInfo($type, $id)["result"][0]["id"];
		$result = $this->db->updateUsersInfo("id = $id", [$record=>$value]);

		return $result;
	}

	public function delete($id, $type) {
		$result = [];
		$uid = $this->giController->getUserInfo($type, $id)["result"][0]["id"];
		array_push($result, $this->db->deleteUserInfo("id = $uid"));
		array_push($result, $this->db->deleteUser("id = $id"));

		return $result;
	}

}

?>