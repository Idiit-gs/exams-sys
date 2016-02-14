<?php
/**
* Score Controller
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 12/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Request;

use Examsys\Api\Utils\ParamHandler;
use Examsys\Api\Utils\Messages;
use Examsys\Api\Utils\ApiInterface;

class SessionController {
	protected $db;

	public function __construct(\Examsys\Api\Utils\OrmManager $ormManager = null) {
		if ($ormManager != null) {
			$this->db = $ormManager->getORM();
		}
		$this->giController = new GetInfoController($ormManager);
	}

	public function newSession($session) {
		$result = $this->db->newSession($session, "");

		return $result;
	}

	public function editSession($session_id, $record, $value) {
		
		$result = $this->db->updateScore("session_id = $session_id", [$record=>$value]);

		return $result;
	}

	public function getSessions() {
		
		$result = $this->db->getSession();

		return $result;
	}

	public function deleteSession($session_id) {
		
		$result = $this->db->deleteSession("session_id = $session_id");

		return $result;
	}
}

?>