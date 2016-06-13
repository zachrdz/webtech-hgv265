<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/Lecture2/"."globals.php";
	include_once $home_path.'error_reporting.php';
	require_once $home_path.'db/dbQuery.php';
	
	session_start();
	
	$username = $_POST['username'];
	$pwd = $_POST['password'];
	
	$dbQuery = new DBQuery;
	$user = $dbQuery->validate_user($username, $pwd);
	
	/* fetch object array */
	if(isset($user)){
		$_SESSION["username"] = $user["username"];
		$_SESSION["firstname"] = $user["firstname"];
		$_SESSION["lastname"] = $user["lastname"];
		header("Location: ../feed.php");
	} else{
		header("Location: ../login.php?error=Invalid%20Login");
	}
?>