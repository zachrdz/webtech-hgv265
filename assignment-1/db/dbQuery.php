<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php";
	include_once $home_path.'error_reporting.php';
	require_once $home_path.'db/dbConn.php';
	
	class DBQuery {
		
		public function validate_user($username, $pwd){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$row = null;
			
			$username = $this->sanitizeString($username);
			$pwd = $this->sanitizeString($pwd);
			
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
			
			$username = $this->sanitizeString($username);
			
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
			
			$uid = $this->sanitizeString($uid);
			
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
				
				$username = $this->sanitizeString($newUserInfo["username"]);
				$email = $this->sanitizeString($newUserInfo["email"]);
				$pwd = $this->sanitizeString($newUserInfo["password"]);
				$firstname = $this->sanitizeString($newUserInfo["firstname"]);
				$lastname = $this->sanitizeString($newUserInfo["lastname"]);
				$dob = $this->sanitizeString($newUserInfo["birthday"]);
				$country = $this->sanitizeString($newUserInfo["country"]);
				$state = $this->sanitizeString($newUserInfo["state"]);
				$city = $this->sanitizeString($newUserInfo["city"]);
				$zipcode = $this->sanitizeString($newUserInfo["zipcode"]);
				$gender = $this->sanitizeString($newUserInfo["gender"]);
				$relationship_status = $this->sanitizeString($newUserInfo["relationship_status"]);
				$verification_question = $this->sanitizeString($newUserInfo["verification_question"]);
				$verification_answer = $this->sanitizeString($newUserInfo["verification_answer"]);
				
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
				
				$username = $this->sanitizeString($user["username"]);
				$uid = $this->sanitizeString($user["id"]);
				$content = $this->sanitizeString($content);
				
				$result = $conn->query(
					"INSERT INTO posts (`user_id`, `username`, `content`)
					VALUES ('$uid', '$username', '$content')"
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

		public function delete_post($user, $post_id){

			if(null != $user && null != $post_id){
				$db = new DBConnect;
				$conn = $db->connect_db();

				$uid = $this->sanitizeString($user["id"]);
				$pid = $this->sanitizeString($post_id);

				$result = $conn->query(
					"DELETE FROM posts WHERE id='$pid' AND user_id='$uid'"
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

		public function get_all_posts(){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$rows = null;

			//Check in the DB
			$query = "SELECT * FROM posts ORDER BY id DESC";
			if($result = $conn->query($query)){
				while($row = $result->fetch_assoc()){
					$json[] = $row;
				}

				if(isset($json)){
					$rows = json_encode($json);
				}
			} else{
				$result = null;
			}

			$result->free();
			$conn->close();

			return $rows;
		}

		public function get_post_comments($post_id){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$rows = null;
			$post_id = $this->sanitizeString($post_id);

			//Check in the DB
			$query = "SELECT * FROM comments WHERE post_id='$post_id'";
			if($result = $conn->query($query)){
				while($row = $result->fetch_assoc()){
					$json[] = $row;
				}

				if(isset($json)){
					$rows = json_encode($json);
				}
			} else {
				$result = null;
			}

			$result->free();
			$conn->close();

			return $rows;
		}

		public function create_comment($user, $post_id, $content){

			if(null != $user && null != $content && null != $post_id){
				$db = new DBConnect;
				$conn = $db->connect_db();

				$username = $this->sanitizeString($user["username"]);
				$uid = $this->sanitizeString($user["id"]);
				$pid = $this->sanitizeString($post_id);
				$content = $this->sanitizeString($content);

				$result = $conn->query(
					"INSERT INTO comments (`user_id`, `post_id`, `username`, `content`)
					VALUES ('$uid', '$pid', '$username', '$content')"
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

		public function delete_comment($user, $comment_id){

			if(null != $user && null != $comment_id){
				$db = new DBConnect;
				$conn = $db->connect_db();

				$uid = $this->sanitizeString($user["id"]);
				$cid = $this->sanitizeString($comment_id);

				$result = $conn->query(
					"DELETE FROM comments WHERE id='$cid' AND user_id='$uid'"
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

		public function like_post($user, $post_id){

			if(null != $user && null != $post_id){
				$db = new DBConnect;
				$conn = $db->connect_db();

				$username = $this->sanitizeString($user["username"]);
				$uid = $this->sanitizeString($user["id"]);
				$pid = $this->sanitizeString($post_id);

				$result = $conn->query(
					"INSERT INTO post_likes (`post_id`, `user_id`, `username`)
					VALUES ('$pid', '$uid', '$username')"
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

		public function unlike_post($user, $post_id){

			if(null != $user && null != $post_id){
				$db = new DBConnect;
				$conn = $db->connect_db();

				$uid = $this->sanitizeString($user["id"]);
				$pid = $this->sanitizeString($post_id);

				$result = $conn->query(
					"DELETE FROM post_likes WHERE post_id='$pid' AND user_id='$uid'"
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

		public function get_post_likes($post_id){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$rows = null;
			$post_id = $this->sanitizeString($post_id);

			//Check in the DB
			$query = "SELECT * FROM post_likes WHERE post_id='$post_id'";
			if($result = $conn->query($query)){
				while($row = $result->fetch_assoc()){
					$json[] = $row;
				}
				if(isset($json)){
					$rows = json_encode($json);
				}
			} else {
				$result = null;
			}

			$result->free();
			$conn->close();

			return $rows;
		}
		
		public function get_user_likes_post($post_id, $user_id){
			$db = new DBConnect;
			$conn = $db->connect_db();
			$count = 0;

			$post_id = $this->sanitizeString($post_id);
			$user_id = $this->sanitizeString($user_id);

			//Check in the DB
			$query = "SELECT * FROM post_likes WHERE post_id='$post_id' AND user_id='$user_id'";
			if($result = $conn->query($query)){
				while($row = $result->fetch_assoc()){
					$count++;
					break;
				}
			}

			$result->free();
			$conn->close();
			
			if($count > 0){
				return true;
			} else{
				return false;
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

		private function sanitizeString($var){
			$db = new DBConnect;
			$conn = $db->connect_db();

			$var = strip_tags($var);
			$var = htmlentities($var);
			$var = stripslashes($var);
			$var = $conn->real_escape_string($var);

			$conn->close();
			return $var;
		}
	}

?>