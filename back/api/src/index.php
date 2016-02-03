<?php
	require "../vendor/autoload.php";

	use Psr\Http\Message\ServerRequestInterface;
	use Psr\Http\Message\ResponseInterface;

	$app = new Slim\App();

	$app->get("/login", function(ServerRequestInterface $request, ResponseInterface $response) {
		//implement login handler and pass it as a DI service in here
	});

	$app->run();