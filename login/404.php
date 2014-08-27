<?php
require_once("models/config.php");

// Always a public page!

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

    <title>phpReports - 404 Oh Noes!</title>

    <link rel="icon" type="image/x-icon" href="css/favicon.ico" />
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">
	
	<link rel="stylesheet" href="css/font-awesome.min.css">
	 
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/userfrosting.js"></script>

  </head>

  <body>
    <div class="container">
      <div class="header">
        <h3 class="text-muted">phpReports</h3>
      </div>
      <div class="jumbotron">
        <h1>Well dang.</h1>
        <p class="lead">We are so, so, so, sorry.  That was NOT supposed to happen.  How can we make it up to you?</p>
        <small>By the way, here's what we think might have happened:</small>
		<div class="row">
			<div id='display-alerts' class="col-sm-12">
			  
			</div>
        </div>
      </div>	
      <div class="footer">
        <p>&copy; <a href='http://www.userfrosting.com'>phpReports</a>, 2014</p>
      </div>

    </div> <!-- /container -->

  </body>
</html>

<script>
	$(document).ready(function() {
		alertWidget('display-alerts');  
	});
</script>
