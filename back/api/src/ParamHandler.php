<?php
/**
* Parameter Handler
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api;

class ParamHandler {

	public static function isParamExists($param) {
		return (isset($param) && $param !== null);
	}
}

?>