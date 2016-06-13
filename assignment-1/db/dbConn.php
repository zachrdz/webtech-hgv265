<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/Lecture2/"."globals.php";
	include_once $home_path.'error_reporting.php';
	
	class DBConnect {
		private $dbhost = "turtleboys.com";
		private $dbuser = "cswebtech";
		private $dbpass = "WebTechClass";
		private $dbname = "mydb";

		public function connect_db(){
			// Create connection
			$conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname, 3306);

			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			return $conn;
		}
	}
?>