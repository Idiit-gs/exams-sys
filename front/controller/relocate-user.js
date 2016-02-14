var app = angular.module("Examsys", ['ngCookies']);

app.controller("relocateUserController", function($cookies, $window){
	var user_type = $cookies.get("user_type");

	if (user_type === "Lecturer") {
		$window.location.href="lecturer.php";
	} else if (user_type === "Student") {
		$window.location.href="student.php";
	}
});