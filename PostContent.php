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
	$data = $_POST;
	$id = $content_service -> postExists($data['name']);
	$res="";
	if($id == null){
		$res = $content_service -> writeContent($data);
	} else {
		$res = $content_service -> updateContent($data,$id);
	}
	
	
	if($res == null) {
	  echo json_encode(array('status'=>'failed','message' => 'Error occured while adding or updating the content'));
	} else {
		echo json_encode(array('status'=>'success','data' => $res));
	}
	
	
}
?>