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

app.controller("lecturerController", ["$scope", "$http", "$cookies", "$window", "userProfile", function($scope, $http, $cookies, $window, userProfile){
	var user_type = $cookies.get("user_type");
	var user_id = $cookies.get("user_id");

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
	});

	$http.get("http://www.idiit-gs.com/exrec/back/api/sessions").success(function(data){
		var sessions = [];
		for (var i = 0; i < Object.keys(data.result).length; i++){
			sessions[i] = data.result[i];
		}
		$scope.SESSIONS = sessions;
	});

	$scope.loadCourse = function(course_id, course_name, course_desc){
		
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
		});
	};
	
	$scope.loadDashboard = function(){
		$scope.PAGE_TITLE_HEADER = "Dashboard";
		$scope.PAGE_TITLE_DESC = "Built with you in mind";
		$scope.SHOWDASHBOARD = true;
		$scope.SHOWRESULTS = false;
	};
	
	function showLoadingAnim(){
		$scope.SHOWDASHBOARD = false;
		$scope.SHOWRESULTS = false;
		$scope.SHOWLOADING = true;
	};

	$scope.logout = function(){
		$cookies.put("user_id", "");
		$cookies.put("user_type", "");
		$cookies.put("login_status", "");

		$window.location.href="login.php";
	}
}]);