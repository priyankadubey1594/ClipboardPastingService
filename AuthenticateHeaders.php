<?php
require("Config/settings.php");
class AuthenticateHeaders{
	public $headers;
	private $access_key;

	public function __construct($headers) {
		$this->headers = $headers; 
	}

	public function validateAccessKey () {
		//$this->access_key = $this->headers['Authorization'];
		$this->access_key = $this->headers['X-AccessKey'];
	}

	private function getAPIAccessKey() {
		if($this->access_key == __ACCESSKEY__) {
			return true;
		}
		return false;
	}
}
?>