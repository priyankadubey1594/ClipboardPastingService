<?php
//This piece is commented since localhost's not accepting authorization headers for CORS
// require('AuthenticateHeaders.php');
// $request_headers = apache_request_headers();
// $auth_headers= new AuthenticateHeaders($request_headers);
// $authenticated=$auth_headers->validateAccessKey();

$http_method=$_SERVER['REQUEST_METHOD'];
if($http_method === "POST") 
{
	require("Models/ContentService.php");

	$content_service = new ContentService (new Database);
	$data= $_POST;
	//$authenticate_access = $content_service->AuthenticateAccess($data);

	$res = $content_service->AuthenticateAccess($data);
		if($res == null) {
		  echo json_encode(array('status'=>'failed','message' => 'The requested resource is either exipred or the password entered is incorrect'));
		} else {
			echo json_encode(array('status'=>'success','data' => $res));
		}	
}	
?>