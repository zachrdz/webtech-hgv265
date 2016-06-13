<?php require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"></link>
		<link rel="stylesheet" href="css/login.css"></link>
	</head>
	<body>
	
		<div class="container">
			<?php 
				include_once $home_path.'error_reporting.php';
			?>
			<div class="row">
				<div class="center">
					<form class="form-signin mg-btm" action="phpscripts/validate_user.php" method="POST">
					<h3 class="heading-desc">
					Login</h3>

					<div class="main">	
						<label>Username</label>    
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="username" class="form-control" placeholder="Username" autofocus required>
						</div>
						<label>Password   <!--<a href="">(forgot password)</a>--></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
				
						<div class="row">
							<div class="col-xs-6 col-md-6">
								 
							</div>
							<div class="col-xs-6 col-md-6 pull-right">
								<button type="submit" class="btn btn-large btn-success pull-right">Login</button>
							</div>
						</div>
					</div>
					
					<span class="clearfix"></span>	

					<div class="login-footer">
						<div class="row">
							<div class="col-xs-6 col-md-6">
								<div class="left-section">
									<a href="sign_up.php">Create an account</a>
								</div>
							</div>
							<div class="col-xs-6 col-md-6 pull-right">
							</div>
						</div>
					</div>
				  </form>
			  </div>
			</div>
		</div>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>