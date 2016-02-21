<?php
/**
* Course Controller
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

class CourseController {
	protected $db;
	private $giController;

	public function __construct(\Examsys\Api\Utils\OrmManager $ormManager = null) {
		if ($ormManager != null) {
			$this->db = $ormManager->getORM();
		}
		$this->giController = new GetInfoController($ormManager);
	}

	public function isRequestValid($variables) {
		$user_type = $this->giController->convertUserTypeToId($variables[0]);
		if (is_null($user_type)) {
			return null;
		}

		$user_info = $this->giController->getUserInfo($user_type, $variables[1]);

		if (is_null($user_info)) {
			return null;
		} else if ($user_info === false) {
			return null;
		}

		return true;
	}

	public function getCourseInfo($course_id) {
		$course = $this->db->getCourse("id = $course_id");
		return $course;
	}

	public function getLecturerCourses($id) {
		$courses = $this->db->getLecturersCourse("lecturer_id = $id");
		$_courses = [];
		foreach ($courses["result"] as $course) {
			array_push($_courses, $this->getCourseInfo($course["course_id"]));
		}
		return $_courses;
	}

	public function deleteLecturerCourses($id, $course) {
		$courses = $this->db->deleteLecturersCourse("lecturer_id = $id AND course_id = $course");
		return $courses;
	}

	public function getStudentCourses($id) {
		$courses = $this->db->getStudentsCourse("student_id = $id");
		$_courses = [];
		foreach ($courses["result"] as $course) {
			array_push($_courses, $this->getCourseInfo($course["course_id"]));
		}
		return $_courses;
	}

	public function deleteStudentCourses($id, $course) {
		$courses = $this->db->deleteStudentCourse("student_id = $id AND course_id = $course");
		return $courses;
	}

	public function getCourseOffers($id) {
		$courses = $this->db->getStudentsCourse("course_id = $id");
		$_courses = [];
		foreach ($courses["result"] as $course) {
			$_course = [];
			$_student_info = $this->giController->getUserInfo($this->giController->convertUserTypeToId("student"), $course["student_id"]);
			array_push($_course, $_student_info);

			array_push($_courses, $_course);
		}
		$_courses["course_info"] = $this->getCourseInfo($course["course_id"]);
		return $_courses;
	}

	public function newStudentFromCourse($firstname, $lastname, $regno, $score, $course, $session){
		//REGISTER USER IN USER_INFO TABLE
		$result = $this->db->newUserInfo(["first_name"=>$firstname, "last_name"=>$lastname]);
		$user_info = $result["lastInsertId"];
		//CREATE STUDENT IN USERS TABLE
		$user_type = $this->giController->convertUserTypeToId("student");
		$result = $this->db->newUser([
				"user_type"=>$user_type, "user_info"=>$user_info, "user_name"=>NULL, "email"=>NULL,
				"phone_number"=>NULL, "password"=>NULL
			]);
		$user_id = $result["lastInsertId"];
		//USE ID RETURNED TO ASSIGN STUDENT COURSE
		$result = $this->db->assignStudentCourse($user_id, $course);
		//RECORD SCORES
		$result = $this->db->newScore([
				"student_id"=>$user_id, "course_id"=>$course, "session_id"=>$session, 
				"score"=>$score, "grade"=>"NULL"
			]);
		//CREATE STUDENT COURSE INFO
		$result = $this->db->newStudentCourseInfo([
				"student_id"=>$user_id,
				"course_id"=>$course,
				"reg_number"=>$regno,
				"full_name"=>"$firstname $lastname"
			]);

		return $result;
	}
}

?>