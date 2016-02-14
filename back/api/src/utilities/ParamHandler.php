<?php
/**
* Parameter Handler
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package Examsys\Api;
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Utils;

class ParamHandler {

	public static function isParamExists($param) {
		//echo $param;
		return true;
	}

	public static function isScoreArrayValid($score_array) {
		if (
			isset($score_array["student_id"]) &&
			isset($score_array["course_id"])  &&
			isset($score_array["session_id"]) &&
			isset($score_array["score"])	  &&
			isset($score_array["grade"])
		) {
			return true;
		}

		return false;
	}
}

?>