<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php";
    include_once $home_path.'error_reporting.php';
    require_once $home_path.'db/dbQuery.php';

    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php?error=You must login!");
    }

    $username = $_SESSION['username'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

    $dbQuery = new DBQuery;
    $user = $dbQuery->get_user_by_username($username);
    $pid = $_GET['pid'];
    $comments = json_decode($dbQuery->get_post_comments($pid));
?>

<?php if(null != $comments) {foreach ($comments as $comment){ ?>
    <div class="col-sm-12">
        <div class="panel panel-white post panel-shadow">
            <div class="post-heading">
                <div class="pull-left image">
                    <img src="http://i.stack.imgur.com/WmvM0.png" class="img-circle avatar" alt="user profile image">
                </div>
                <div class="pull-left meta">
                    <div class="title h5">
                        <a href="#"><b><?php echo $comment->username; ?></b></a>
                    </div>
                    <h6 class="text-muted time"><?php echo date("m/d/y g:ia", strtotime($comment->created_at));?></h6>
                </div>
            </div>
            <div class="post-description">
                <p><?php echo $comment->content; ?></p>

                <div class="stats">
                    <!-- TODO: Implement deletion of user created comments button -->
                </div>
            </div>
        </div>
    </div>
<?php }} else{
    echo "No one has commented on this post.";
} ?>