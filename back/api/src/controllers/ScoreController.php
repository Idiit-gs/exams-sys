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

class ScoreController {
	protected $db;

	public function __construct(\Examsys\Api\Utils\OrmManager $ormManager = null) {
		if ($ormManager != null) {
			$this->db = $ormManager->getORM();
		}
		$this->giController = new GetInfoController($ormManager);
	}

	public function newScore($score) {
		$result = $this->db->newScore($score);

		return $result;
	}

	public function editScore($student, $course, $session, $record, $value) {
		
		$result = $this->db->updateScore("student_id = $student AND course_id = $course AND session_id = $session", [$record=>$value]);

		return $result;
	}

	public function getScore($student, $course, $session) {
		
		$result = $this->db->getScore("student_id = $student AND course_id = $course AND session_id = $session");

		$score[] = $result["result"][0];

		$_student_info = $this->giController->getUserInfo($this->giController->convertUserTypeToId("student"), $result["result"][0]["student_id"]);
		$score["info"] = $_student_info["result"][0];

		return $score;
	}

	public function getScoreByCourse($course, $session) {
		
		$result = $this->db->getScore("course_id = $course AND session_id = $session");
		$scores = [];
		for ($i = 0; $i < count($result["result"]); $i++){
			$score[] = $result["result"][$i];

			$_student_info = $this->giController->getUserInfo($this->giController->convertUserTypeToId("student"), $result["result"][0]["student_id"]);
			$score[] = $_student_info["result"][0];

			array_push($scores, $score);
			$score = [];
		}
		return $scores;
	}

	public function deleteScore($student, $course, $session) {
		
		$result = $this->db->deleteScore("student_id = $student AND course_id = $course AND session_id = $session");

		return $result;
	}
}

?>