<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/vendor/autoload.php';
$Router = new Klein\Klein;

$Router->with('/api/v1', function() use ($Router){
	$Router->respond('POST', '/access_token', function($req, $res){
		$AccessTokenController = new Controllers\AccessTokenController;
		return $AccessTokenController->handle();
	});
});

$Router->onHttpError(function ($code, $router) {
	echo $code;
	if ($code == 404) {
		$service = $router->service();
	}
});

$Router->dispatch();
