<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php";
    include_once $home_path.'error_reporting.php';
    require_once $home_path.'db/dbQuery.php';

    session_start();

    $uid = $_POST['uid'];
    $pid = $_POST['pid'];

    $dbQuery = new DBQuery;
    $user = $dbQuery->get_user_by_id($uid);

    if(null != $user && null != $pid){
        $post = $dbQuery->delete_post($user, $pid);
    } else{
        $msg = "Post deletion failed!";
    }

    if(isset($post) && $post == "Success"){
        echo "Success";
    } else{
        echo $msg;
    }
?>