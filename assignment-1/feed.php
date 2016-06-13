<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/Lecture2/"."globals.php";
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
		<!--
		<div>
			<p>Logged in as <?php echo $username; ?></p>
			<p><b>Hello <?php echo "$firstname $lastname"; ?>!</b></p>
		<div>
		<div>
			<form action="phpscripts/post.php" method="POST">
				<input value="<?php echo $user["id"]; ?>" type="text" style="display:none;" name="uid"/>
				<textarea rows="4" cols="50" name="content"></textarea>
				<input value="Submit Post" type="submit"/>
			</form>
		<div>
		<div>
			<form action="phpscripts/logout.php" method="POST">
				<input value="Logout" type="submit"/>
			</form>
		<div>
		-->
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
				<form action="phpscripts/post.php" method="POST">
					<div class="form-group well">
						<label for="content">New Post</label>
						<input value="<?php echo $user["id"]; ?>" type="text" style="display:none;" name="uid"/>
						<textarea class="form-control" style="resize: none;" rows="4" cols="50" id="content" name="content" required></textarea>
						</br>
						<input class="btn btn-default" value="Submit Post" type="submit"/>
					</div>
				</form>
            </div>
        </div>
        <!-- /.row -->
		
		<!-- row -->
		<div class="row">
					<div class="col-md-12">
						<div class="blog-comment">
							<h3 class="text-info">Feed</h3>
							<hr/>
							<ul class="comments">
								<li class="clearfix">
								  <img src="http://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
								  <div class="post-comments">
									  <p class="meta">Dec 18, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Like</small></a> | <a href="#"><small>Dislike</small></a></i></p>
									  <p>
										  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
										  Etiam a sapien odio, sit amet
									  </p>
								  </div>
								</li>
								<li class="clearfix">
								  <img src="http://bootdey.com/img/Content/user_2.jpg" class="avatar" alt="">
								  <div class="post-comments">
									  <p class="meta">Dec 19, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Like</small></a> | <a href="#"><small>Dislike</small></a></i></p>
									  <p>
										  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
										  Etiam a sapien odio, sit amet
									  </p>
								  </div>
								
								</li>
							</ul>
						</div>
					</div>
				</div>
		<!-- /.row -->

    </div>
    <!-- /.container -->
	<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>
