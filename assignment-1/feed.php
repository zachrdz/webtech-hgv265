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
?>
<html>
	<head>
		<title>Account Home</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"></link>
		<link rel="stylesheet" href="css/feed.css"></link>
	</head>
	<body>
		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">CSWebTech</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="phpscripts/logout.php">Logout</a>
						</li>
						<!--<li>
							<a href="#">Link2</a>
						</li>
						<li>
							<a href="#">Link3</a>
						</li>-->
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>

		<!-- Page Content -->
		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					<h2>Welcome, <?php echo $firstname; ?></h2>
					<div class="form-group well">
						<form action="phpscripts/post.php" method="POST" id="new-post">

								<label for="content">New Post</label>
								<input id="post_uid" value=<?php echo $user["id"]; ?> name="uid" style="display:none;"/>
								<textarea class="form-control" style="resize: none;" rows="4" cols="50" id="post_content" name="content" required></textarea>
								</br>
								<a class="btn btn-default createpost">Submit Post</a>

						</form>
						<span style="display:none;" id="submitting"><h3>Submitting..</h3></span>
					</div>
				</div>
			</div>
			<!-- /.row -->

			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<div class="feed-post">
						<h3 class="text-info">Feed</h3>
						<hr/>
						<div id="posts"></div>
					</div>
				</div>
			</div>
			<!-- /.row -->

		</div>
    	<!-- /.container -->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script>
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
		</script>

	</body>
</html>
