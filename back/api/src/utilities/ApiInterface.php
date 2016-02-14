<?php
/**
* API INTERFACE
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Utils;

interface ApiInterface {

	public function __construct(\Examsys\Api\Utils\OrmManager $ormManager);

	public function __invoke($request, $response, $callable);
}

?>