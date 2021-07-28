<?php
require("require('../Config/Database.php');");

class Queries {

private $conn;

public function __construct( IDatabase $database)
{
		$this->conn = $database;
}
 
$sql="create table posts(id int AUTO_INCREMENT, name varchar(50), password varchar(300), content text, expiration datetime, exposure varchar(10), created_on datetime, updated_on timestamp, PRIMARY KEY(id), UNIQUE KEY (`name`))";
mysqli_execute($conn, $sql);

}
?>