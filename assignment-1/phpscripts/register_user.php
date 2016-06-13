<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php";
	include_once $home_path.'error_reporting.php';
	require_once $home_path.'db/dbQuery.php';
	
	$dbQuery = new DBQuery;
	$result = $dbQuery->register_user($_POST);
	
	if($result == "Success"){
		header("Location: ../login.php?info=$result");
	} else{
		header("Location: ../sign_up.php?error=$result");
	}
?>