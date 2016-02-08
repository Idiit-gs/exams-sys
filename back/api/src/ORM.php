<?php
/**
* ORM
* Database Handler.
*
* @author: Samuel Adeshina <samueladeshina73@gmail.com> <>
* @package idiit-gs\examsys\backend\api
* @since: 2/2/2016.
* @license: 
* @version 0.1
*/

namespace Examsys\Api\DB;

use Plug\Framework\DBAL\QueryBuilder\QueryBuilder as QueryBuilder;
use Plug\Framework\DBAL\Connection\Query as Query;

class ORM {
	private $queryBuilder;
	private $db_location;

	public function __construct() {
		//connect to db
		$this->db_location = $_SERVER["DOCUMENT_ROOT"]."/src/DBAL/database";
	}

	public function getQueryBuilder() {
		return new QueryBuilder();
	}

	private function run($string){
		$query = new Query($string, $this->db_location);

		$error = $query->result()[1][2];

		if ($error != "") {
			throw new \Exception($error);
		}

		return array("result"=>$query->result()[0], "lastInsertId"=>$query->result()[2]);
	}

	public function newUserType($name, $description = "") {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("user_types", "name, description")
							->values($name, $description)
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function newUserInfo($user_info) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("user_info", "first_name, last_name")
							->values($user_info["first_name"], $user_info["last_name"])
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function newUser($user) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("users", "user_type, user_info, user_name, email, phone_number, password")
							->values($user["user_type"],$user["user_info"],$user["user_name"],$user["email"],$user["phone_number"],$user["password"])
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function newCourse($name, $description) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("courses", "name, description")
							->values($name, $description)
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function assignLecturerCourse($lecturer, $course) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("lecturer_courses", "lecturer_id, course_id")
							->values($lecturer, $course)
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function assignStudentCourse($student, $course) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("student_courses", "student_id, course_id")
							->values($student, $course)
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function newSession($name, $description) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("sessions", "name, description")
							->values($name, $description)
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function newScore($score) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->insert()
							->into("scores", "student_id, course_id, session_id, score, grade")
							->values($score["student_id"],$score["course_id"],$score["session_id"],$score["score"],$score["grade"])
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	protected function update($table, $options, $condition = "") {

		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->update($table);
		foreach ($options as $option_array) {

			foreach ($option_array as $option=>$value) {
				$query_string = $query_string->set($option, $value);
			}
		}
		if ($condition !== "") {
			$query_string = $query_string->where($condition);
		}

		$query_string = $queryBuilder->build();

		$result = $this->run($query_string);
		return $result;
	}

	public function updateCourse($condition, ...$options) {
		return $this->update("courses", $options, $condition);
	}

	public function updateLecturersCourse($condition, ...$options) {
		return $this->update("lecturer_courses", $options, $condition);
	}

	public function updateScore($condition, ...$options) {
		return $this->update("scores", $options, $condition);
	}

	public function updateSession($condition, ...$options) {
		return $this->update("sessions", $options, $condition);
	}

	public function updateStudentsCourse($condition, ...$options) {
		return $this->update("student_courses", $options, $condition);
	}

	public function updateUsersInfo($condition, ...$options) {
		return $this->update("user_info", $options, $condition);
	}

	public function updateTypes($condition, ...$options) {
		return $this->update("user_types", $options, $condition);
	}

	public function updateUser($condition, ...$options) {
		return $this->update("users", $options, $condition);
	}

	protected function delete($table, $condition) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->delete($table)
							->where($condition)
							->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function deleteUser($condition) {
		return $this->delete("users", $condition);
	}

	public function deleteUserType($condition) {
		return $this->delete("user_types", $condition);
	}

	public function deleteUserInfo($condition) {
		return $this->delete("user_info", $condition);
	}

	public function deleteStudentsCourse($condition) {
		return $this->delete("student_courses", $condition);
	}

	public function deleteSession($condition) {
		return $this->delete("sessions", $condition);
	}

	public function deleteScore($condition) {
		return $this->delete("scores", $condition);
	}

	public function deleteLecturersCourse($condition) {
		return $this->delete("lecturer_courses", $condition);
	}

	public function deleteCourse($condition) {
		return $this->delete("courses", $condition);
	}

	protected function get($table, $condition) {
		$queryBuilder = $this->getQueryBuilder();
		$query_string = $queryBuilder
							->select()
							->from($table);
		if ($condition !== "") {
			$query_string = $query_string->where($condition);
		}
		$query_string = $query_string->build();
		$result = $this->run($query_string);
		return $result;
	}

	public function getCourse($condition="") {
		return $this->get("courses", $condition);
	}

	public function getLecturersCourse($condition="") {
		return $this->get("lecturer_courses", $condition);
	}

	public function getScore($condition="") {
		return $this->get("scores", $condition);
	}

	public function getSession($condition="") {
		return $this->get("sessions", $condition);
	}

	public function getStudentsCourse($condition="") {
		return $this->get("student_courses", $condition);
	}

	public function getUserInfo($condition="") {
		return $this->get("user_info", $condition);
	}

	public function getUserType($condition="") {
		return $this->get("user_types", $condition);
	}

	public function getUser($condition="") {
		return $this->get("users", $condition);
	}

}

?>