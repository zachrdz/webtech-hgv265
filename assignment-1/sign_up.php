<?php require_once $_SERVER['DOCUMENT_ROOT']."/hgv265/assignment-1/"."globals.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		
		<!-- Custom CSS -->
		<link rel="stylesheet" href="css/signup_form.css">
	</head>
	<body>
		<?php 
			include_once $home_path.'error_reporting.php';
		?>
		<form action="phpscripts/register_user.php" method="POST" class="form-horizontal signupform">
			<fieldset>
				<legend><h2>Sign Up</h2></legend>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Username</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Username" name="username" aria-describedby="helpBlock" type="text" pattern="[A-Za-z0-9_]{4,}" required/>
						<span id="helpBlock" class="help-block">Must be at least 4 characters, alphanumeric and underscore characters only</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Email</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Email" name="email" type="email" required/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Password</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Password" id="password" name="password" type="password" pattern=".{8,}" aria-describedby="helpBlock" required/>
						<span id="helpBlock" class="help-block">Must be at least 8 characters</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Re-Enter Password</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Password" name="confirm_password" id="confirm_password" type="password" required/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>First Name</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="First Name" name="firstname" type="text" required/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Last Name</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Last Name" name="lastname" type="text" required/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Birthday</b></label>
					<div class="col-sm-3">
						<input class="form-control" placeholder="Birthday" name="birthday" type="date"/>
					</div>
				</div>
				<div class="form-group" id="country">
					<label class="col-sm-2 control-label"><b>Country</b></label>
					<div class="col-sm-5">
						<select name="country" id="countrylist" class="form-control" onchange="validateCountryState()">
							<?php include($home_path.'lists/country.php'); ?>
						</select>
					</div>
				</div>
				<div class="form-group" id="state">
					<label class="col-sm-2 control-label"><b>State</b></label>
					<div class="col-sm-3">
						<select name="state" id="statelist" class="form-control">
							<?php include($home_path.'lists/state.php'); ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>City</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="City" name="city" type="text"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Zip Code</b></label>
					<div class="col-sm-2">
						<input class="form-control" placeholder="Zip Code" name="zipcode" type="text" pattern="[0-9]{5}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Gender</b></label>
					<div class="col-sm-2">
						<select name="gender" class="form-control">
						  <option value="male">Male</option>
						  <option value="female">Female</option>
						  <option value="default">Other</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Relationship Status</b></label>
					<div class="col-sm-3">
						<select name="relationship_status" class="form-control">
						  <option value="single">Single</option>
						  <option value="in a relationship">In a Relationship</option>
						  <option value="engaged">engaged</option>
						  <option value="married">Married</option>
						  <option value="other">Other</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Security Question</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Security Question" name="verification_question" type="text" required/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Security Answer</b></label>
					<div class="col-sm-5">
						<input class="form-control" placeholder="Security Answer" name="verification_answer" type="text" required/>
					</div>
				</div>
				<hr></hr>
				<div class="row">
					<div class="col-sm-12">
						<div class="text-center">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-default"><a href="login.php">Cancel</a></button>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
		
		<!-- Custom JS -->
		<script src="js/sign_up.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>