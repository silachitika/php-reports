<?php

require_once("models/config.php");

setReferralPage(getAbsoluteDocumentPath(__FILE__));

$validate = new Validator();
$token = $validate->optionalGetVar('confirm');
$confirmAjax = 0;

if(!empty($token)){$confirmAjax = 1;}else{$confirmAjax = 0;}

global $token_timeout;
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

    <title>phpReports - Reset Password</title>

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
        <h1>Reset Password</h1>
        <?php
        if(!$token){
            echo'
          <p class="lead">
            Please enter your username and the email address you used to sign up.
            A link with instructions to reset your password will be emailed to you.
        </p>';
        }else{
            echo'
          <p class="lead">
            Please enter your username and your new password to continue.
        </p>';
        }?>

        <form class='form-horizontal' role='form' name='reset_password' action='api/user_reset_password.php' method='post'>
            <div class="row">
                <div id='display-alerts' class="col-lg-12">

                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-3 col-md-6">
                    <input type="text" class="form-control" placeholder="Username" name = 'username' value=''>
                </div>
            </div>
            <?php
            if(!$token){

                echo '<div class="form-group">
                  <div class="col-md-offset-3 col-md-6">
                      <input type="email" class="form-control" placeholder="Email" name=\'email\' value=\'\'>
                  </div>
              </div>';
            }else{
                echo '<div class="form-group">
                  <div class="col-md-offset-3 col-md-6">
                      <input type="password" class="form-control" placeholder="New Password" name = \'password\' value=\'\'>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-offset-3 col-md-6">
                      <input type="password" class="form-control" placeholder="Password Confirm" name = \'passwordc\' value=\'\'>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-offset-3 col-md-6">
                      <input type="hidden" class="form-control" placeholder="Token" name = \'token\' value=\''.$token.'\'>
                  </div>
              </div>';
            } ?>

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success submit" value='Reset'>Reset Password</button>
                </div>
            </div>
        </form>
    </div>
    <div class="footer">
        <p>&copy; <a href='http://www.userfrosting.com'>phpReports</a>, 2014</p>
    </div>

</div> <!-- /container -->
<script>
    $(document).ready(function() {
        // Load the header
        $(".navbar").load("header-loggedout.php", function() {
            $(".navbar .navitem-login").addClass('active');
        });

        alertWidget('display-alerts');

        $("form[name='reset_password']").submit(function(e){
            var form = $(this);
            var url = APIPATH + 'user_reset_password.php';
            var confirm = <?php echo $confirmAjax; ?>;

            if(confirm==0)
            {
                var formdata = {
                    username:	form.find('input[name="username"]').val(),
                    email:		form.find('input[name="email"]').val(),
                    initial:    "1",
                    ajaxMode:	"true"
                }
            }
            else
            {
                var formdata = {
                    username:	form.find('input[name="username"]').val(),
                    password:	form.find('input[name="password"]').val(),
                    passwordc:  form.find('input[name="passwordc"]').val(),
                    token:      form.find('input[name="token"]').val(),
                    ajaxMode:	"true"
                }
            }
            $.ajax({
                type: "POST",
                url: url,
                data: formdata
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
