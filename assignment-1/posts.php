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

<?php foreach ($posts as $post){
    $likes = json_decode($dbQuery->get_post_likes($post->id));
    $liked = false;
    if(null != $likes) {
        // Check if user has already liked this post
        $userLikesPost = $dbQuery->get_user_likes_post($post->id, $user["id"]);
        if($userLikesPost){
            $liked = true;
        }
    }
    $likeLabel = ($liked) ? 'Unlike' : 'Like';
?>
<div class="col-sm-12">
    <div class="panel panel-white post panel-shadow">
        <div class="post-heading">
            <div class="pull-left image">
                <img src="http://i.stack.imgur.com/WmvM0.png" class="img-circle avatar" alt="user profile image">
            </div>
            <div class="pull-left meta">
                <div class="title h5">
                    <a href="#"><b><?php echo $post->username; ?></b></a>
                </div>
                <h6 class="text-muted time"><?php echo date("m/d/y g:ia", strtotime($post->created_at));?></h6>
            </div>
        </div>
        <div class="post-description">
            <p><?php echo $post->content; ?></p>

            <hr>
            <div class="input-group replyToPost">
                <input type="text" class="form-control replyContent" placeholder="Write a comment...">
						<span class="input-group-btn">
							<button class="btn btn-secondary replyToPostBtn" type="button"
                                    data-pid="<?php echo $post->id; ?>"
                                    data-uid="<?php echo $user["id"]; ?>"
                                >Send</button>
						</span>
            </div>
            <hr>

            <div class="stats">
                <a href="#" onClick="return false;" class="btn btn-default btn-sm stat-item like-button"
                   data-pid="<?php echo $post->id; ?>"
                   data-toggle="tooltip"
                   data-placement="top"
                   data-username="<?php echo $user["username"]; ?>"
                   data-uid="<?php echo $user["id"]; ?>"
                   title="<?php if(null != $likes){foreach ($likes as $like){ echo $like->username."<br>"; }}?>"
                >
                    <span class="likeLabel" style="display: none;"><?php echo $likeLabel;?></span>
                    <i class="fa fa-thumbs-up icon" style='color:<?php if($liked == true){echo "blue";}else{echo "black";} ?>;'></i>
                    (<span class="likeNumber"><?php echo count($likes); ?></span>)
                </a>

                <a href="#" onClick="return false;" class="btn btn-default btn-sm comments-button stat-item"
                   data-pid="<?php echo $post->id; ?>"
                   data-username="<?php echo $post->username; ?>"
                   data-toggle="modal"
                   data-target="#commentsModal">
                    <i class="fa fa-reply icon"></i>
                    Comments
                </a>

                <?php if($post->user_id == $user["id"]){ ?>
                <a href="#" onClick="return false;" class="btn btn-default btn-sm stat-item delete-button"
                   data-pid="<?php echo $post->id; ?>"
                   data-uid="<?php echo $user["id"]; ?>"
                    >
                    <i class="fa fa-times icon"></i>
                    Delete
                </a>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<?php } ?>


<!-- Modal -->
<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="commentsModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="commentsBody">
                <!-- Load comments into here -->
                <img class="center-block" style="height: 50px;" src="http://growingmail.com/themes/growingmail/assets/img/loading_circle_large.gif"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src="js/posts.js"></script>