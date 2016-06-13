<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php";
	include_once $home_path.'error_reporting.php';
	require_once $home_path.'db/dbQuery.php';
	
	session_start();
	
	$uid = $_POST['uid'];
	$pid = $_POST['pid'];
	$content = $_POST['content'];
	
	$dbQuery = new DBQuery;
	$user = $dbQuery->get_user_by_id($uid);
	
	if(null != $user && null != $content){
		$post = $dbQuery->create_comment($user, $pid, $content);
	} if(null == $content){
		$post = "You must enter a comment to send!";
	}
	
	
	/* fetch object array */
	if(isset($post) && $post == "Success"){
		echo "Success";
	} else{
		echo "Post Failed! ".$post;
	}
?>