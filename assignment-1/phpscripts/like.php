<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php";
    include_once $home_path.'error_reporting.php';
    require_once $home_path.'db/dbQuery.php';

    session_start();

    $uid = $_POST['uid'];
    $pid = $_POST['pid'];
    $like = $_POST['like'];

    $dbQuery = new DBQuery;
    $user = $dbQuery->get_user_by_id($uid);

    if(null != $user && null != $pid && $like == "true"){
        $post = $dbQuery->like_post($user, $pid);
    } if(null != $user && null != $pid && $like == "false"){
        $post = $dbQuery->unlike_post($user, $pid);
    } if(null == $pid){
        $msg = "Post like/unlike failed!";
    }

    if(isset($post) && $post == "Success"){
        echo "Success";
    } else{
        echo $msg;
    }
?>