var app = require("./app-module.js");

app.factory("userProfile", ["$http", "$cookies", function($http, $cookies){
	return function(){
		var user_type = $cookies.get("user_type");
		var user_id = $cookies.get("user_id");
		var api_url = "http://www.idiit-gs.com/exrec/back/api/"+user_type+"/info/"+user_id;
		var user_info = $http.get(api_url);
		return user_info;
	}
}]);

app.controller(
	"lecturerController", ["$scope", "$http", "$cookies", "$window", "$timeout", "userProfile", 
	function($scope, $http, $cookies, $window, $timeout, userProfile) {
	var user_type = $cookies.get("user_type");
	var user_id = $cookies.get("user_id");
	if (user_id == "" || user_type == ""){
		$window.location.href="login.php";
	}
	var current_course;

	 $scope.sortType     = 'name';
	 $scope.sortReverse  = false;
	 $scope.searchName   = '';


	$scope.SHOWDASHBOARD = true;
	$scope.PAGE_TITLE_HEADER = "Dashboard";
	$scope.PAGE_TITLE_DESC = "Built with you in mind";
	userProfile().success(function(data){
		var profile = data.result[0];
		$scope.LECTURER_NAME = profile.first_name+" "+profile.last_name;
	});

	$http.get("http://www.idiit-gs.com/exrec/back/api/lecturer/course/"+user_id).success(function(data){ 
		var courses = [];
		for (var i = 0; i < Object.keys(data).length; i++){
			courses[i] = data[i].result[0];
		}
		$scope.COURSES = courses;
		$scope._COURSES = courses;
	});

	$http.get("http://www.idiit-gs.com/exrec/back/api/sessions").success(function(data){
		var sessions = [];
		for (var i = 0; i < Object.keys(data.result).length; i++){
			sessions[i] = data.result[i];
		}
		$scope.SESSIONS = sessions;
	});

	$scope.loadCourse = function(course_id, course_name, course_desc){
		current_course = course_id;
		if (typeof session == "undefined"){
			$scope.SESSION = 1;
		}
		var session = $scope.SESSION;
		showLoadingAnim();
		$scope.TSCORES = [];
		$scope.PAGE_TITLE_HEADER = course_name;
		$scope.PAGE_TITLE_DESC = course_desc;
		$http.get("http://www.idiit-gs.com/exrec/back/api/score/course?course="+course_id+"&session="+session).success(function(data){
			var courses = [];
			for (var i = 0; i < Object.keys(data).length; i++){
				courses[i] = {"score_info":data[i][0], "student_info":data[i][1]};
			}
			$scope.SCORES = courses;
			$scope.SHOWDASHBOARD = false;
			$scope.SHOWLOADING = false;
			$scope.SHOWRESULTS = true;
			$scope.SHOWFILEUPLOAD = false;
		});
	};
	
	$scope.loadDashboard = function(){
		$scope.PAGE_TITLE_HEADER = "Dashboard";
		$scope.PAGE_TITLE_DESC = "Built with you in mind";
		$scope.SHOWDASHBOARD = true;
		$scope.SHOWRESULTS = false;
		$scope.SHOWFILEUPLOAD = false;
	};

	$scope.loadFileUpload = function(){
		$scope.PAGE_TITLE_HEADER = "Upload Results";
		$scope.PAGE_TITLE_DESC = "Drop a csv file into the space provided";
		$scope.SHOWFILEUPLOAD = true;
		$scope.SHOWRESULTS = false;
		$scope.SHOWDASHBOARD = false;
	};
	
	function showLoadingAnim(){
		$scope.SHOWDASHBOARD = false;
		$scope.SHOWRESULTS = false;
		$scope.SHOWFILEUPLOAD = false;
		$scope.SHOWLOADING = true;
	};

	$scope.registerNewStudent = function(){
		var reg_num = $scope.reg_num;
		var first_name = $scope.first_name;
		var last_name = $scope.last_name;
		var score = $scope.score;
		var course = current_course;
		if (typeof session == "undefined"){
			$scope.SESSION = 1;
		}
		var session = $scope.SESSION;

		$http.post(
			"http://www.idiit-gs.com/exrec/back/api/course/student/new?firstname="+
			first_name+"&lastname="+
			last_name+"&regnum="+
			reg_num+"&score="+
			score+"&course="+
			course+"&session="+session
		)
		.success(function(data){
			$scope.reg_num = "";
			$scope.first_name = "";
			$scope.last_name = "";
			$scope.score = "";
			$scope.submit_success = true;
			$timeout(function(){
				$scope.submit_success = false;
			}, 3000);
		});
	}

	$scope.logout = function(){
		$cookies.put("user_id", "");
		$cookies.put("user_type", "");
		$cookies.put("login_status", "");

		$window.location.href="login.php";
	}
}]);