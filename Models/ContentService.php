<?php
require('Config/Database.php');
class ContentService
{
	private $conn;
	private $entity = "posts";

	public function __construct( IDatabase $database)
	{
		$this->conn = $database->db_connect();
	}


	public function writeContent($data) {
		$name = $this->conn->real_escape_string($data['name']);
		$password =  $this->conn->real_escape_string($data['password']);
		$content = $this->conn->real_escape_string($data['content']);
		$expiration = $this->conn->real_escape_string($data['expiration']);
		$exposure = $this->conn->real_escape_string($data['exposure']);

		$query = "insert into ". $this->entity."(name, password, content, expiration, exposure, created_on) values('$name', md5('$password'), '$content', DATE_ADD(now(), INTERVAL ".$expiration." DAY), '$exposure', now())";
		try 
		{
			$this->res = $this->conn->query($query);
			if(! $this->res)
			{
				throw new Exception("Insert query failed");
			}
			$insert_id = $this->conn->insert_id;
			
		} 
		catch (Exception $e) 
		{
			return 'Query Execution Error: '. $e->getMessage();
			//return $query;
		}
		return $insert_id;
	}

	public function getContent($id, $is_authenticated) 
	{
		$id = $this->conn->real_escape_string($id);

		$current_date_time = $this->getCurrentDateTime();

		$query = "select id, name, content, expiration, exposure from ".$this->entity." where id=".$id. " and expiration >= '$current_date_time'";
			$this->res = $this->conn->query($query);
			$result_set = array();
			while ($row = $this->res->fetch_assoc())
			{
				if($row['exposure'] == 'restricted' && $is_authenticated==false)
				{
					$result_set = array('id '=> $row['id'], 'exposure'=> $row['exposure']);
				} 
				else 
				{
					$result_set = array('id' => $row['id'], 'exposure' => $row['exposure'], 'expired' => false,'name' => $row['name'], 'content' => $row['content']);
				}
			} 
		return $result_set;
	}
	
	public function updateContent($data, $id) 
	{
		$name = $this->conn->real_escape_string($data['name']);
		$password =  $this->conn->real_escape_string($data['password']);
		$content = $this->conn->real_escape_string($data['content']);
		$expiration = $this->conn->real_escape_string($data['expiration']);
		$exposure = $this->conn->real_escape_string($data['exposure']);

		$query = "update ".$this->entity." set name= '$name', password='$password', content='$content', expiration=DATE_ADD(now(), INTERVAL ".$expiration." DAY), exposure='$exposure' where id=".$id;
			$this->res = $this->conn->query($query);
			if($this->res) {
				return $id;
			}
			return $query;
	}

	public function AuthenticateAccess($data) 
	{
		$id = $this->conn->real_escape_string($data['postId']);
		$password = $this->conn->real_escape_string($data['password']);
		$current_date_time = $this->getCurrentDateTime();

		$query = "select id, name, content, expiration, exposure from ".$this->entity." where id=".$id. " and expiration >= '$current_date_time' and password=md5('$password')";
		$this->res = $this->conn->query($query);
		$row = $this->res->fetch_assoc();
		$result_set = array();
		if( $this->res->num_rows>0) {
			$result_set = array('id' => $row['id'], 'exposure' => $row['exposure'], 'expired' => false,'name' => $row['name'], 'content' => $row['content']);
		}
		return $result_set;
	}

	public function postExists($name) {
		$name = $this->conn->real_escape_string($name);
		$query="select id from posts where name='$name'";
		$this->res = $this->conn->query($query);
		if( $this->res->num_rows>0) {
			$row = $this->res->fetch_assoc();
			return $row['id'];
		}
		return null;
	}

	public function getCurrentDateTime() 
	{
		date_default_timezone_set("Asia/Kolkata");
        return date("Y-m-d H:i:s");
	}
}
 
?>