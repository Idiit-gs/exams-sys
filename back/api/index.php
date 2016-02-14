<?php
/**
* ExamSys API Request Router.
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

# IMPORT
require __DIR__."/vendor/autoload.php";

use Examsys\Api\Request\LoginController;
use Examsys\Api\Utils\OrmManager;
use Examsys\Api\DB\ORM;
use Examsys\Api\Utils\ParamHandler;
use Examsys\Api\Utils\Messages;

//header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

# SETUP
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

/*$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);

$cors = new \CorsSlim\CorsSlim($corsOptions);

$app->add($cors);*/

$config = new \Slim\Container($configuration);

$app = new Slim\App($config); //

$db = new ORM();

$ormManager = new OrmManager();
$paramHandler = new ParamHandler();
$ormManager->setORM($db);

$app->any("/", function($request, $response, $args){
	//handle request to the root level directory
});

# LOGIN

$loginController = new LoginController($ormManager);

$app->post("/login", function($request, $response, $args) use($app) {
	if (
		ParamHandler::isParamExists($request->getQueryParams()["username"]) &&
		ParamHandler::isParamExists($request->getQueryParams()["password"])
	) {
		
		return $response;
	}
	else {
		/**
		 * @todo inject a custom exception handler in here.
		 * \BadParameterException ?
		 */
		throw new \Exception(Messages::LOGIN_BAD_PARAMETER_ERROR);
	}

})->add( $loginController );

## CONTROLLERS SECTION

use Examsys\Api\Request\GetInfoController as GIController;
use Examsys\Api\Request\EditInfoController as EIController;
use Examsys\Api\Request\CourseController as CourseController;
use Examsys\Api\Request\ScoreController as ScoreController;
use Examsys\Api\Request\SessionController as SessionController;

$giController = new GIController( $ormManager );
$eiController = new EIController( $ormManager );
$courseController = new CourseController( $ormManager );
$scoreController = new ScoreController( $ormManager );
$sessionController = new SessionController( $ormManager );

# GET USER INFO

$app->get("/{user_type}/info/{user_id:[0-9]+}", function($request, $response, $args) use ($giController) {
	
		$variables = [
				$args["user_type"],
				$args["user_id"]
		];

		$user_type = $giController->convertUserTypeToId($variables[0]);
		if (is_null($user_type)) {
			throw new \Exception(Messages::INVALID_USER_TYPE_REQUEST);
		}

		$user_info = $giController->getUserInfo($user_type, $variables[1]);

		if (is_null($user_info)) {
			throw new \Exception(Messages::USER_NOT_FOUND);
		} else if ($user_info === false) {
			throw new \Exception(Messages::USER_RECORD_NOT_FOUND);
		}

		$response->getBody()->write(json_encode($user_info, JSON_FORCE_OBJECT));

		$response = $response->withHeader("Content-Type", "application/json");
		
		return $response;
});


$app->put("/{user_type}/info/{user_id:[0-9]+}/edit", function($request, $response, $args) use ($eiController, $giController) {
	$variables = [
			$args["user_type"],
			$args["user_id"]
	];

	$user_type = $giController->convertUserTypeToId($variables[0]);

	if (!$eiController->isRequestValid($variables)) {
		throw new \Exception(Messages::INVALID_USER_EDIT_REQUEST);
	}

	$params = $request->getQueryParams();
	$result = [];
	foreach ($params as $param=>$value) {
		array_push($result, $eiController->editUserInfo($variables[1], $user_type, $param, $value));
	}

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});


$app->delete("/{user_type}/info/{user_id:[0-9]+}/delete", function($request, $response, $args) use($eiController, $giController) {
	$variables = [
			$args["user_type"],
			$args["user_id"]
	];

	$user_type = $giController->convertUserTypeToId($variables[0]);

	if (!$eiController->isRequestValid($variables)) {
		throw new \Exception(Messages::INVALID_USER_DELETE_REQUEST);
	}

	$result = $eiController->delete($variables[1], $user_type);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;

});

$app->get("/{user_type}/course/{user_id:[0-9]+}", function($request, $response, $args) use ($giController, $courseController) {
	
	$variables = [
			$args["user_type"],
			$args["user_id"]
	];

	$user_type = $giController->convertUserTypeToId($variables[0]);
	if (!$courseController->isRequestValid($variables)) {
		throw new \Exception(Messages::USER_NOT_FOUND);
	}

	if (strtolower($variables[0]) === "lecturer"){
		$result = $courseController->getLecturerCourses($variables[1]);
	}
	else if (strtolower($variables[0]) === "student"){
		$result = $courseController->getStudentCourses($variables[1]);
	} else {
		$result = [];
	}

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->delete("/{user_type}/course/{user_id:[0-9]+}/delete", function($request, $response, $args) use ($giController, $courseController) {
	
	$variables = [
			$args["user_type"],
			$args["user_id"]
	];

	$user_type = $giController->convertUserTypeToId($variables[0]);
	if (!$courseController->isRequestValid($variables)) {
		throw new \Exception(Messages::USER_NOT_FOUND);
	}

	$course = $request->getQueryParams()["course_id"];

	if (strtolower($variables[0]) === "lecturer"){
		$result = $courseController->deleteLecturerCourses($variables[1], $course);
	}
	else if (strtolower($variables[0]) === "student"){
		$result = $courseController->deleteStudentCourses($variables[1], $course);
	} else {
		$result = [];
	}

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->get("/course/students/{course_id:[0-9]+}", function($request, $response, $args) use ($giController, $courseController) {
	
	$variables = [
			$args["course_id"]
	];

	$result = $courseController->getCourseOffers($variables[0]);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->get("/course/{course_id:[0-9]+}", function($request, $response, $args) use ($giController, $courseController) {
	
	$variables = [
			$args["course_id"]
	];

	$result = $courseController->getCourseInfo($variables[0]);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->post("/score/new", function($request, $response, $args) use($scoreController) {
	$score = $request->getQueryParams();

	if (!ParamHandler::isScoreArrayValid($score)) {
		throw new \Exception(Messages::MISSING_SCORE_PARAMS);
	}

	$result = $scoreController->newScore($score);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->put("/score/edit", function($request, $response, $args) use($scoreController) {
	$student = $request->getQueryParams()["student"];
	$course = $request->getQueryParams()["course"];
	$session = $request->getQueryParams()["session"];

	$params = $request->getQueryParams();
	$result = [];
	foreach ($params as $param=>$value) {
		if ($param != "student" && $param != "course" && $param != "session") {
			array_push($result, $scoreController->editScore($student, $course, $session, $param, $value));
		}
	}

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->get("/score", function($request, $response, $args) use($scoreController) {
	$student = $request->getQueryParams()["student"];
	$course = $request->getQueryParams()["course"];
	$session = $request->getQueryParams()["session"];

	$result = $scoreController->getScore($student, $course, $session);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->get("/score/course", function($request, $response, $args) use($scoreController) {
	$course = $request->getQueryParams()["course"];
	$session = $request->getQueryParams()["session"];

	$result = $scoreController->getScoreByCourse($course, $session);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->delete("/score/delete", function($request, $response, $args) use($scoreController) {
	$student = $request->getQueryParams()["student"];
	$course = $request->getQueryParams()["course"];
	$session = $request->getQueryParams()["session"];

	$result = $scoreController->deleteScore($student, $course, $session);

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});

$app->get("/sessions", function($request, $response, $args) use($sessionController) {

	$result = $sessionController->getSessions();

	$response->getBody()->write(json_encode($result, JSON_FORCE_OBJECT));

	$response = $response->withHeader("Content-Type", "application/json");

	return $response;
});
# RUN

$app->run();

?>