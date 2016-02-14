<?php
/**
* A string resource
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 1/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\Utils;

class Messages {

	const LOGIN_BAD_PARAMETER_ERROR = "A username and password must be provided as post variables in other to continue";
	const INVALID_LOGIN_DETAIL = "Invalid login detail supplied. Please try again or ask for help";
	const INVALID_USER_TYPE_REQUEST = "Invalid User Type Requested";
	const USER_NOT_FOUND = "The user you requested does not exist";
	const USER_RECORD_NOT_FOUND = "The user you requested is not associated with any information";
	const INVALID_USER_EDIT_REQUEST = "The user you want to edit does not exist";
	const INVALID_USER_DELETE_REQUEST = "The User you want to delete does not exist";
	const MISSING_SCORE_PARAMS = "An expected information was not provided.";
}

?>