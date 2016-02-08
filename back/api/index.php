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
use Examsys\Api\Orm\OrmManager;
use Examsys\Api\DB\ORM;
use Examsys\Api\ParamHandler;
use Examsys\Api\Messages;

# SETUP
/*$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$config = new \Slim\Container($configuration);
*/
$app = new Slim\App(); //$config

$db = new ORM();

$ormManager = new OrmManager();
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


# RUN

$app->run();

?>