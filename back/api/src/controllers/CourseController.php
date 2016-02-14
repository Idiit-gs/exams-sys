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
}

?>