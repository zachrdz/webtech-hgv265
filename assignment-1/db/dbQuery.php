<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/Lecture2/"."globals.php";
	include_once $home_path.'error_reporting.php';
	require_once $home_path.'db/dbConn.php';
	
	class DBQuery {
		
		public function validate_user($username, $pwd){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$row = null;
			
			$username = $conn->real_escape_string($username);
			$pwd = $conn->real_escape_string($pwd);
			
			//Check in the DB
			$query = "SELECT * FROM users WHERE username='$username'";
			if($result = $conn->query($query)){
				$row = $result->fetch_assoc();
			}
			
			// If the password is not correct, send back null
			// http://www.php.net/manual/en/function.password-hash.php
			if(isset($row) && !password_verify($pwd, $row["password"])){
				$row = null;
			}

			$result->free();
			$conn->close();
			
			return $row;
		}
		
		public function get_user_by_username($username){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$row = null;
			
			$username = $conn->real_escape_string($username);
			
			//Check in the DB
			$query = "SELECT * FROM users WHERE username='$username'";
			if($result = $conn->query($query)){
				$row = $result->fetch_assoc();
			} else {
				$result = null;
			}

			$result->free();
			$conn->close();
			
			return $row;
		}
		
		public function get_user_by_id($uid){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$row = null;
			
			$uid = $conn->real_escape_string($uid);
			
			//Check in the DB
			$query = "SELECT * FROM users WHERE id='$uid'";
			if($result = $conn->query($query)){
				$row = $result->fetch_assoc();
			} else {
				$result = null;
			}

			$result->free();
			$conn->close();
			
			return $row;
		}
		
		public function register_user($newUserInfo){
			
			if(isset($newUserInfo["username"]) && isset($newUserInfo["email"]) && isset($newUserInfo["password"]) && isset($newUserInfo["firstname"]) && isset($newUserInfo["lastname"])){
				$db = new DBConnect;
				$conn = $db->connect_db();
				
				$username = $conn->real_escape_string($newUserInfo["username"]);
				$email = $conn->real_escape_string($newUserInfo["email"]);
				$pwd = $conn->real_escape_string($newUserInfo["password"]);
				$firstname = $conn->real_escape_string($newUserInfo["firstname"]);
				$lastname = $conn->real_escape_string($newUserInfo["lastname"]);
				$dob = $conn->real_escape_string($newUserInfo["birthday"]);
				$country = $conn->real_escape_string($newUserInfo["country"]);
				$state = $conn->real_escape_string($newUserInfo["state"]);
				$city = $conn->real_escape_string($newUserInfo["city"]);
				$zipcode = $conn->real_escape_string($newUserInfo["zipcode"]);
				$gender = $conn->real_escape_string($newUserInfo["gender"]);
				$relationship_status = $conn->real_escape_string($newUserInfo["relationship_status"]);
				$verification_question = $conn->real_escape_string($newUserInfo["verification_question"]);
				$verification_answer = $conn->real_escape_string($newUserInfo["verification_answer"]);
				
				$pass = $this->hash_password($pwd);
				
				$result = $conn->query(
					"INSERT INTO users (`username`, `email`, `password`, `firstname`, `lastname`, `dob`, `country`, `state`, `city`, `zipcode`, `gender`, `relationship_status`, `verification_question`, `verification_answer`)
					VALUES ('$username', '$email', '$pass', '$firstname', '$lastname', '$dob', '$country', '$state', '$city', '$zipcode', '$gender', '$relationship_status', '$verification_question', '$verification_answer')"
				);
				
				if($result){
					$msg = "Success";
				} else{
					$msg = $conn->error;
				}
			  
				$conn->close();
				
				return $msg;
			} else{
				return "Failure";
			}
		}
		
		public function create_post($user, $content){
			
			if(null != $user && null != $content){
				$db = new DBConnect;
				$conn = $db->connect_db();
				
				$username = $conn->real_escape_string($user["username"]);
				$uid = $conn->real_escape_string($user["id"]);
				$profile_pic = $conn->real_escape_string($user["profile_pic"]);
				$content = $conn->real_escape_string($content);
				
				$result = $conn->query(
					"INSERT INTO posts (`user_id`, `username`, `content`, `profile_pic`)
					VALUES ('$uid', '$username', '$content', '$profile_pic')"
				);
				
				if($result){
					$msg = "Success";
				} else{
					$msg = $conn->error;
				}
			  
				$conn->close();
				
				return $msg;
			} else{
				return "Failure";
			}
		}
		
		private function hash_password($pwd){
			// http://www.php.net/manual/en/function.password-hash.php
			$options = [
				'cost' => 11,
			];

			$hash = password_hash($pwd, PASSWORD_BCRYPT, $options);
			return $hash;
		}
	}

?>