$(document).ready(function() {
    $('.like-button').tooltip({html: true});

    $('.like-button').click(function () {

        var post_id = $(this).data('pid');
        var username = $(this).data('username');
        var user_id = $(this).data('uid');
        var like = $(this).find('.likeLabel').text();
        var thumbsUpIcon = $(this).find('.fa');

        // If already liked, set like to false
        if(like != "Like"){
            like = false;

            //Update field label
            thumbsUpIcon.css('color', 'black');
            $(this).find('.likeLabel').text('Like');
            $(this).find('.likeNumber').text(+$(this).find('.likeNumber').text() - 1);
            $(this).attr("data-original-title", $(this).attr("data-original-title").replace(username+"<br>",""));
        } else{
            like = true;

            //Update field label
            thumbsUpIcon.css('color', 'blue');
            $(this).find('.likeLabel').text('Unike');
            $(this).find('.likeNumber').text(+$(this).find('.likeNumber').text() + 1);
            $(this).attr("data-original-title", $(this).attr("data-original-title") + username + '<br>');
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

    $('.comments-button').click(function () {
        var postContent = $(this).parent().parent().find("p:first").text();
        var pid = $(this).data("pid");
        var username = $(this).data("username");
        $('#commentsModalLabel').html('<strong>' + username + "</strong>: " +postContent);
        $("#commentsBody").load('comments.php?pid='+pid);
    });

    $('#commentsModal').on('hidden.bs.modal', function () {
        // Clear out modal body on close
        $("#commentsBody").html('<img class="center-block" style="height: 50px;" src="http://growingmail.com/themes/growingmail/assets/img/loading_circle_large.gif"/>');
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