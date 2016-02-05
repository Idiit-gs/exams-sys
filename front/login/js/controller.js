/**
* Process Login
*
* @author Samuel Adeshina <samueladeshina73@gmail.com>
* @since 4/2/2016
*/

var app = angular.module("Examsys", []);

app.controller("projectController", function($scope){
	var project = {
		"name":"EXAMSYS",
		"short_sentence":"Transforming Exams by removing tem from System"
	};
	$scope.project = project;
});

app.controller("loginController", function($scope, $http){
	$scope.processLogin = function(){
		var username = $scope.username;
		var password = $scope.password;
		$http({
			method: "POST",
			url : ""
		}).then(function(response){
			
		}, function(response){

		});
	}
});

app.controller("registrationController", function($scope){

});