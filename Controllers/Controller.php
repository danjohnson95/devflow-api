<?php

class Controller{

	private $Errors = [];

	public function returnErrors(){
		echo json_encode(array('errors' => $this->Errors));
	}

	public function doRequest($obj){
		$c = curl_init($obj['url']);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		if(isset($obj['form'])){
			curl_setopt($c, CURLOPT_HTTPHEADER, ['Content-Type'=>'application/x-www-form-urlencoded']);
			curl_setopt($c, CURLOPT_POST, count($obj['form']));
			curl_setopt($c, CURLOPT_POSTFIELDS, $obj['form']);
		}else{
			curl_setopt($c, CURLOPT_HTTPHEADER, ['Content-Type'=>'application/json']);
		}
		if(isset($obj['auth'])){
			curl_setopt($c, CURLOPT_USERPWD, $obj['auth']);
		}

		echo curl_exec($c);
		curl_close($c);
		die();

	}
}