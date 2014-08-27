<?php

require_once("models/config.php");

setReferralPage(getAbsoluteDocumentPath(__FILE__));

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("danger", "I'm sorry, you cannot register for an account while logged in.  Please log out first.");
	header("Location: account.php");
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="css/favicon.ico">

    <title>phpReports - Resend Activation Email</title>

	<link rel="icon" type="image/x-icon" href="css/favicon.ico" />
	
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">
	
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap-switch.min.css" type="text/css" />
	 
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/userfrosting.js"></script>
	<script src="js/date.min.js"></script>
    <script src="js/handlebars-v1.2.0.js"></script> 

  </head>

  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills navbar pull-right">
        </ul>
        <h3 class="text-muted">phpReports</h3>
      </div>
      <div class="jumbotron">
        <h1>Account Activation</h1>
        <p class="lead">Please enter your username and the email address you used to sign up, and an activation email will be resent.</p> 
		<form class='form-horizontal' role='form' name='resend' action='user_resend_activation.php' method='post'>
		  <div class="row">
			<div id='display-alerts' class="col-lg-12">
  
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="text" class="form-control" placeholder="Username" name = 'username' value=''>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="email" class="form-control" placeholder="Email" name='email'>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-12">
			  <button type="submit" class="btn btn-success submit" value='Resend'>Resend Activation</button>
			</div>
		  </div>
		</form>
      </div>	
  
    </div> <!-- /container -->

	<script>
        $(document).ready(function() {          
			// Load the header
			$(".navbar").load("header-loggedout.php", function() {
				$(".navbar .navitem-login").addClass('active');
			});
		  	
			alertWidget('display-alerts');
			  
		  	$("form[name='resend']").submit(function(e){
				var form = $(this);
				var url = 'user_resend_activation.php';
				$.ajax({  
				  type: "POST",  
				  url: url,  
				  data: {
					username:	form.find('input[name="username"]').val(),
					email:		form.find('input[name="email"]').val(),
					ajaxMode:	"true"
				  }		  
				}).done(function(result) {
				  resultJSON = processJSONResult(result);
				  alertWidget('display-alerts');
				});
				// Prevent form from submitting twice
				e.preventDefault();
		    });
		});
	</script>
  </body>
</html>