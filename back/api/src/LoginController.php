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

namespace Examsys\Api;

class LoginController implements ApiInterface {
	protected $db;

	public function __construct(\Examsys\Api\Orm\OrmManager $ormManager) {
		$this->db = $ormManager->getORM();
	}

	public function __invoke($request, $response, $next_callable) {
		$username = $request->post("username");
		$password = $request->post("password");

		$isCredentialsValid = $this->isCredentialsValid($username, $password);

		$response->getBody()->write($isCredentialsValid);

		$response = $next_callable($request, $response);

		return json_encode($response, JSON_FORCE_OBJECT);
	}

	protected function isCredentialsValid($username, $password) {
		return $this->validateCredentials($username, $password);
	}

	private function validateCredentials($username, $password) {
		$user = $this->db->getPassword($username);

		return $password === $user["password"];
	}
}

?>