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

use Examsys\Api\LoginController;
use Examsys\Api\Orm\OrmManager;
use Examsys\Api\DB\ORM;

# SETUP

$app = new Slim\App();

$db = new ORM();

$ormManager = new OrmManager();
$ormManager->setORM($db);

$app->any("/", function($request, $response, $args){
	//handle requests to the root level directory
});

# LOGIN

$loginController = new LoginController($ormManager);

$app->post("/login", function($request, $response, $args){

})->add( $loginController );


# RUN

$app->run();

?>