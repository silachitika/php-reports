<?php

require_once("../models/config.php");

if (!securePage(__FILE__)){
  // Forward to index page
  addAlert("danger", "Whoops, looks like you don't have permission to view that page.");
  header("Location: index.php");
  exit();
}

setReferralPage(getAbsoluteDocumentPath(__FILE__));

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PHP Reports Admin - Users</title>

    <?php require_once("includes.php");  ?>
 
    <!-- Page Specific Plugins -->
    <link rel="stylesheet" href="../css/bootstrap-switch.min.css" type="text/css" />
  
    <script src="../js/date.min.js"></script>
    <script src="../js/handlebars-v1.2.0.js"></script> 
    <script src="../js/bootstrap-switch.min.js"></script>
	<script src="../js/jquery.tablesorter.js"></script>
	<script src="../js/tables.js"></script>    
    <script src="../js/widget-users.js"></script>
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      </nav>

      <div id="page-wrapper">
	  	<div class="row">
          <div id='display-alerts' class="col-lg-12">

          </div>
        </div>
        <div class="row">
          <div id='widget-users' class="col-lg-12">          

          </div>
        </div><!-- /.row -->
        
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
    </div>
    <script>
        $(document).ready(function() {
          // Load the header
          $('.navbar').load('header.php', function() {
            $('.navitem-users').addClass('active');
          });
                              
          alertWidget('display-alerts');
          
          usersWidget('widget-users', {
            title: 'Users',
            limit: 1000,
            sort: 'asc',
            columns: {
              user_info: 'User/Info',
              user_sign_in: 'Last Sign-in',
              user_since: 'User Since',
              action: 'Actions'
            }
          }); 
        });      
    </script>
  </body>
</html>
