<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/Lecture2/"."globals.php";
	include_once $home_path.'error_reporting.php';
	require_once $home_path.'db/dbQuery.php';
	
	session_start();
	
	$uid = $_POST['uid'];
	$content = $_POST['content'];
	
	$dbQuery = new DBQuery;
	$user = $dbQuery->get_user_by_id($uid);
	
	if(null != $user && null != $content){
		$post = $dbQuery->create_post($user, $content);
	} if(null == $content){
		$post = "You must enter a message to send!";
	}
	
	
	/* fetch object array */
	if(isset($post) && $post == "Success"){
		header("Location: ../feed.php?info=Post Submitted!");
	} else{
		header("Location: ../feed.php?error=Post Failed! $post");
	}
?>