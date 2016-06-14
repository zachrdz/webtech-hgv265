$(document).ready(function(){
    $("#posts").load('posts.php');
});

$('.createpost').click(function () {

    var content = $('#post_content').val();
    var user_id = $('#post_uid').val();
    if(content.length <= 0){
        alert("Nothing Entered!");
    } else{
        $('#new-post').hide();
        $('#submitting').show();
        $.ajax
        ({
            url: 'phpscripts/post.php',
            data: {"uid": user_id, "content": content},
            type: 'post',
            success: function (result) {
                $('#post_content').val('');
                $('#submitting').hide();
                $('#new-post').show();
                if(result == "Success"){
                    $("#posts").load('posts.php', function() {
                        $('#postInfoMsgCallback').html(
                            "<div class='alert alert-success alert-dismissible' role='alert'>"+
                            "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+
                            "Post submitted successfully."+
                            "</div>"
                        );
                    });
                }
            }
        });
    }
});
