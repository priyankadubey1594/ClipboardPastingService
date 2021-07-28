<?php
//This piece is commented since localhost's not accepting custom headers for CORS
// require('AuthenticateHeaders.php');
// $request_headers = apache_request_headers();
// $auth_headers= new AuthenticateHeaders($request_headers);

// $authenticated=$auth_headers->validateAccessKey();

$http_method=$_SERVER['REQUEST_METHOD']; 
if(isset($_GET['postId'])) 
{
	require("Models/ContentService.php");

	$content_service = new ContentService (new Database);
	$postId = $_GET['postId'];

		$is_authenticated=false;
		$res = $content_service->getContent($postId,false);
		if($res == null) {
		  echo json_encode(array('status'=>'failed','message' => 'The requested resource is either exipred or not found'));
		} else {
			echo json_encode(array('status'=>'success','data' => $res));
		}		
}


?>