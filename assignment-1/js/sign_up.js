// Compare Password Confirmation
var password = document.getElementById("password");
var confirm_password = document.getElementById("confirm_password");

function comparePassword(){
  if(password.value != confirm_password.value) {
	confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
	confirm_password.setCustomValidity('');
  }
}

password.onchange = comparePassword;
confirm_password.onkeyup = comparePassword;

function validateCountryState(){
	var country = document.getElementById("countrylist").value;
	var state = document.getElementById("state");
	if(country != "US"){
		state.style.display = "none";
		state.value = "";
	} else{
		state.style.display = "block";
	}
}
