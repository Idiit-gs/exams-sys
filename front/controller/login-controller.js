/**
* Process Login
*
* @author Samuel Adeshina <samueladeshina73@gmail.com>
* @since 4/2/2016
*/
var app = angular.module("Examsys", ['ngCookies']);

app.controller("loginController", function($scope, $http, $cookies, $window){
	$scope.information = "Welcome, please login";
	$scope.processLogin = function(){
		var username = $scope.username;
		var password = $scope.password;
		if (typeof username != "undefined" && typeof password != "undefined") {
			$scope.information = "Processing... Please wait";
			var login_data = "username="+username+"&password="+password;
			var login_api_url = "http://www.idiit-gs.com/exrec/back/api/login?"+login_data;
			$http.post(login_api_url)
			.success(function(data){
				if (data.login_status == 1) {
					$cookies.put("user_id", data.user_id);
					$cookies.put("user_type", data.user_type);
					$cookies.put("login_status", data.login_status);

					$scope.information="Your login was successful. you're now been redirected to your dashboard";

					$window.location.href="index.php";
				} else {
					$scope.information="No response from server. Please contact an administrator";
				}
			})
			.error(function(data){
				$scope.information="An error occurred. Please try entering your password and username again";
			});		
		}
	}
});