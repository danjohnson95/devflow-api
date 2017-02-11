<?php

define('DISPLAY_ERRORS', TRUE);
define('ERROR_REPORTING', E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

public function base_dir(){
	return __DIR__;
}

//$Router = new Klein\Klein;

print_r('yo');
die();

$Router->with('/api/v1', function() use ($Router){
	$Router->respond('POST', '/access_token', 'AccessTokenController::handle');
});

$Router->dispatch('/');

