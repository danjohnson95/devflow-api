<?php namespace Controllers;

class AccessTokenController extends Controller{

	private $AuthURL = "https://bitbucket.org/site/oauth2/access_token";
	private $Username;
	private $Password;

	public function __construct(){
		$this->getAppConfig();
	}

	private function getAppConfig(){
		$file = file_get_contents(__DIR__.'/config.php');
		
		if(!$file){
			$this->Errors[]['message'] = "Fatal error with API (our fault, soz)";
			return $this->returnErrors();
		}
		
		$file = json_decode($file);
		$this->Username = $file->username;
		$this->Password = $file->password;
		return true;
	}

	private function doValidation(){
		if(!isset($_POST['grant_type'])) $this->Errors[]['field'] = "grant_type";
		if($_POST['grant_type'] != "refresh_token" && $_POST['grant_type'] != "authorization_code") $this->Errors[]['field'] = "grant_type";
		if($_POST['grant_type'] == "authorization_code" && !isset($_POST['code'])) $this->Errors[]['field'] = "code";
		if($_POST['grant_type'] == "refresh_token" && !isset($_POST['refresh_token'])) $this->Errors[]['field'] = "refresh_token";
	}

	private function buildBody(){
		if($_POST['grant_type'] == "authorization_code"){
			return [
				'grant_type' => 'authorization_code',
				'code' => $_POST['code']
			];
		}else{
			return [
				'grant_type' => 'refresh_token',
				'refresh_token' => $_POST['refresh_token']
			];
		}
	}
	
	public function handle(){
		$this->doValidation();
		if(!count($this->Errors)){
			$this->returnErrors();
		}else{
			$this->doRequest([
				'url' => $this->AuthURL,
				'auth' => $this->Username.":".$this->Password,
				'form' => $this->buildBody()
			]);
		}
	}
}
