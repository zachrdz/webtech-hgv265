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
$posts = json_decode($dbQuery->get_all_posts());
?>

<ul class="posts">
    <?php foreach ($posts as $post){ ?>
        <?php
        $likes = json_decode($dbQuery->get_post_likes($post->id));
        $liked = "false";
        if(null != $likes) {
            // Check if user has already liked this post
            foreach ($likes as $like){
                if($like->user_id == $user["id"]) {
                    $liked = "true";
                    break;
                }
            }
        }
        $likeLabel = ($liked == "true") ? 'Unlike' : 'Like';
        ?>
        <li class="clearfix">
            <img src="http://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
            <div class="post-items">
                <p class="meta">
                    <?php echo $post->created_at;?>
                    <a href="#posts"><?php echo $post->username;?></a> says :
                    <i class="pull-right">
                        <a href="#" onClick="return false;" class="like-button" data-id="<?php echo $post->id; ?>">
                            <small>
                                <span class="likeLabel"><?php echo $likeLabel;?></span>
                                (<span class="likeNumber"><?php echo count($likes); ?></span>)
                            </small>
                        </a>
                        |
                        <a href="#"><small>Replies</small></a>
                        <?php if($post->user_id == $user["id"]){ ?>
                        |
                        <a href="#" onClick="return false;" class="delete-button" data-id="<?php echo $post->id; ?>"><small>Delete</small></a>
                        <?php } ?>
                    </i></p>
                <p>
                    <?php echo $post->content; ?>
                </p>
            </div>
        </li>
    <?php } ?>
</ul>

<script>
    $(document).ready(function() {
        $('.like-button').click(function () {

            var post_id = $(this).data('id');
            var like = $(this).find('.likeLabel').text();

            // If already liked, set like to false
            if(like != "Like"){
                var like = false;

                //Update field label
                $(this).find('.likeLabel').text('Like');
                $(this).find('.likeNumber').text(+$(this).find('.likeNumber').text() - 1);
            } else{
                var like = true;

                //Update field label
                $(this).find('.likeLabel').text('Unike');
                $(this).find('.likeNumber').text(+$(this).find('.likeNumber').text() + 1);
            }

            $.ajax
            ({
                url: 'phpscripts/like.php',
                data: {"pid": post_id, "uid": <?php echo $user["id"]; ?>, "like": like},
                type: 'post',
                success: function (result) {
                    //$("#posts").load('posts.php');
                }
            });
        });

        $('.delete-button').click(function () {

            var post_id = $(this).data('id');
            $(this).html('<img style="display: inline; height:20px;" src="http://gifyo.com/public/img/loading.gif"/>');

            $.ajax
            ({
                url: 'phpscripts/delete_post.php',
                data: {"pid": post_id, "uid": <?php echo $user["id"]; ?>},
                type: 'post',
                success: function (result) {
                    $("#posts").load('posts.php');
                }
            });
        });
    });
</script>