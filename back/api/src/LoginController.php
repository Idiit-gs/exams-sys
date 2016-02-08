<?php
/**
* Login Controller.
* Validates and authenticates user login credentials
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Request;

use Examsys\Api\ParamHandler;
use Examsys\Api\Messages;

class LoginController implements ApiInterface {
	protected $db;

	public function __construct(\Examsys\Api\Orm\OrmManager $ormManager = null) {
		if ($ormManager != null) {
			$this->db = $ormManager->getORM();
		}
	}

	public function __invoke($request, $response, $next_callable) {
		$response = $next_callable($request, $response);

		$username = $request->getQueryParams()["username"];
		$password = $request->getQueryParams()["password"];

		$isCredentialsValid = $this->isCredentialsValid($username, $password);

		$response->getBody()->write($isCredentialsValid);

		$response = $response->withHeader("Content-Type", "application/json");
		
		return $response;
	}

	protected function isCredentialsValid($username, $password) {
		return $this->validateCredentials($username, $password);
	}

	private function validateCredentials($username, $password) {
		$user = $this->db->getUser(self::typeof($username). " = '$username'");
		$password_from_db = $user["result"][0]["password"];
		if ($password_from_db === $password) {
			$usertype = $this->db->getUserType("id = ".$user["result"][0]["user_type"]);
			$userid = $user["result"][0]["id"];
			$return = array("user_id"=>$userid, "user_type"=>$usertype["result"][0]["name"], "login_status"=>1);

			return json_encode($return);
		} else {
			throw new \Exception(Messages::INVALID_LOGIN_DETAIL);
		}
	}

	private function typeof($string) {
		// if (
		// 	filter_var(
		// 		$string,
		// 		FILTER_VALIDATE_REGEXP,
		// 		array("options"=>array(
		// 				"regexp"=>
		// 				"^(1\s*[-\/\.]?)?(\((\d{3})\)|(\d{3}))\s*[-\/\.]?\s*(\d{3})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$"
		// 			)
		// 		)
		// 	)
		// )
		if (is_int($string)) {
			return "phone_number";
		}
		else if(!filter_var($string, FILTER_VALIDATE_EMAIL) === false) {
			return "email";
		}
		else {
			return "user_name";
		}
	}
}

?>