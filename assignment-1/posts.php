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
<div id="postInfoMsgCallback"></div>
<ul class="posts">
    <?php foreach ($posts as $post){ ?>
        <?php
        $likes = json_decode($dbQuery->get_post_likes($post->id));
        $liked = "false";
        if(null != $likes) {
            // Check if user has already liked this post
			$userLikesPost = $dbQuery->get_user_likes_post($post->id, $user["id"]);
            if($userLikesPost){
				$liked = true;
			}
        }
        $likeLabel = ($liked == "true") ? 'Unlike' : 'Like';
        ?>
        <li class="clearfix">
            <img src="http://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
            <div class="post-items">
                <p class="meta">
                    <?php echo date("F j, Y g:ia", strtotime($post->created_at));?>
                    <a href="#posts"><?php echo $post->username;?></a> says :
                    <i class="pull-right">
                        <a href="#" onClick="return false;" class="like-button" 
							data-pid="<?php echo $post->id; ?>"
							data-toggle="tooltip" 
							data-placement="left" 
							data-username="<?php echo $user["username"]; ?>" 
							data-uid="<?php echo $user["id"]; ?>"
							title="<?php if(null != $likes){foreach ($likes as $like){ echo $like->username.'</br>'; }}?>"
						>
                            <small>
                                <span class="likeLabel"><?php echo $likeLabel;?></span>
                                (<span class="likeNumber"><?php echo count($likes); ?></span>)
                            </small>
                        </a>
                        |
                        <a href="#"><small>Replies</small></a>
                        <?php if($post->user_id == $user["id"]){ ?>
                        |
                        <a href="#" onClick="return false;" class="delete-button" 
							data-pid="<?php echo $post->id; ?>" 
							data-uid="<?php echo $user["id"]; ?>"
						>
							<small>Delete</small>
						</a>
                        <?php } ?>
                    </i>
				</p>
                <p>
                    <?php echo $post->content; ?>
					<hr></hr>
					<div class="input-group replyToPost">
						<input type="text" class="form-control replyContent" placeholder="Reply..">
						<span class="input-group-btn">
							<button class="btn btn-secondary replyToPostBtn" type="button" 
								data-pid="<?php echo $post->id; ?>" 
								data-uid="<?php echo $user["id"]; ?>"
							>Reply</button>
						</span>
					</div>
                </p>
            </div>
        </li>
    <?php } ?>
</ul>

<script>
    $(document).ready(function() {
		$('.like-button').tooltip({html: true});
		
		$('.like-button').click(function () {

            var post_id = $(this).data('pid');
			var username = $(this).data('username');
			var user_id = $(this).data('uid');
            var like = $(this).find('.likeLabel').text();

            // If already liked, set like to false
            if(like != "Like"){
                var like = false;

                //Update field label
                $(this).find('.likeLabel').text('Like');
                $(this).find('.likeNumber').text(+$(this).find('.likeNumber').text() - 1);
				$('*[data-pid="'+ post_id +'"]').attr("data-original-title", $('*[data-pid="'+ post_id +'"]').attr("data-original-title").replace(username + '</br>',''));
            } else{
                var like = true;

                //Update field label
                $(this).find('.likeLabel').text('Unike');
                $(this).find('.likeNumber').text(+$(this).find('.likeNumber').text() + 1);
				$('*[data-pid="'+ post_id +'"]').attr("data-original-title", $('*[data-pid="'+ post_id +'"]').attr("data-original-title") + username + '</br>');
            }

            $.ajax
            ({
                url: 'phpscripts/like.php',
                data: {"pid": post_id, "uid": user_id, "like": like},
                type: 'post',
                success: function (result) {
                    //$("#posts").load('posts.php');
                }
            });
        });

        $('.delete-button').click(function () {

            var post_id = $(this).data('pid');
			var user_id = $(this).data('uid');
            $(this).html('<img style="display: inline; height:20px;" src="http://gifyo.com/public/img/loading.gif"/>');

            $.ajax
            ({
                url: 'phpscripts/delete_post.php',
                data: {"pid": post_id, "uid": user_id},
                type: 'post',
                success: function (result) {
                    $("#posts").load('posts.php');
                }
            });
        });
		
		$('.replyToPostBtn').click(function () {

				var content = $(this).parent().parent().find('.replyContent').val();
				var post_id = $(this).data('pid');
				var user_id = $(this).data('uid');
				
				$(this).parent().parent().find('.replyContent').val('');
				$(this).parent().parent().find('.replyContent').text('');
				
				if(content.length <= 0){
					alert("Nothing Entered!");
				} else{
					$.ajax
					({
						url: 'phpscripts/comment.php',
						data: {"uid": user_id, "pid": post_id, "content": content},
						type: 'post',
						success: function (result) {
							if(result == "Success"){
								$('#postInfoMsgCallback').html(
									"<div class='alert alert-success alert-dismissible' role='alert'>"+
										"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+
										"Reply submitted successfully."+
									"</div>"
								);
							}
						}
					});
				}
			});
    });
</script>