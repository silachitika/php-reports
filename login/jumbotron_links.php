<?php
// Request method: GET
include('models/config.php');

if ($can_register){
	echo "
		  <div class='row'>
			  <div class='col-md-12'>
				<a href='register.php' class='btn btn-link' role='button' value='Register'>Not a member yet?  Register here.</a>
			  </div>
		  </div>
		  <div class='row'>
			  <div class='col-md-12'>
				<a href='forgot_password.php' class='btn btn-link' role='button' value='Forgot Password'>Forgot your password?</a>
			  </div>
		  </div>
		  <div class='row'>
			  <div class='col-md-12'>
				<a href='resend_activation.php' class='btn btn-link' role='button' value='Activate'>Resend activation email</a>
			  </div>
		  </div>";
} 
?>
