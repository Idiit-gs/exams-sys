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
		"short_sentence":"Examsys Project Short Sentence"
	};
	$scope.project = project;
});

app.controller("loginController", function($scope, $http){
	$scope.processLogin = function(){
		var username = $scope.username;
		var password = $scope.password;
		var login_data = {username:username, password:password};
		var login_api_url = "http://www.idiit-gs.com/front/api/login";
		$http.post(login_api_url, login_data, function(login_data){
			console.log(data);
		}, function	(){
			console.log(response);
		});
	}
});

app.controller("registrationController", function($scope){

});