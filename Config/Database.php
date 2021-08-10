<?php
/**
 * 
 */

require('settings.php');
require('IDatabase.php');

class Database implements IDatabase
{
	private $host = __HOST__;
	private $username = __USERNAME__;
	private $password = __PASSWORD__;
	private $database = __DATABASE__;
	private static $conn;

	// function __construct(argument)
	// {
	// 	// code...
	// }

	public function db_connect() 
	{
		$this->conn=null;

		try 
		{	if(!self::$conn) {
				self::$conn = new mysqli($this->host, $this->username, $this->password, $this->database);
				if(!self::$conn){
					throw new Exception("Failed to connect to database");
				}
			}		
		} 
		catch (Exception $e) 
		{
			echo 'Connection Error: '. $e->getMessage();
		}
		return self::$conn;
	}
}

?>
