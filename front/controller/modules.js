(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
module.exports = angular.module("Examsys", ["ngCookies"]);
},{}],2:[function(require,module,exports){
(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
module.exports = angular.module("Examsys", ["ngCookies"]);
},{}],2:[function(require,module,exports){
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
		showLoadingAnim();
		var session = $scope.SESSION;
		if (typeof session != "undefined"){
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
		} else {
			alert("Please select a session");
		}
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
},{"./app-module.js":1}]},{},[2]);

},{"./app-module.js":1}]},{},[2]);
