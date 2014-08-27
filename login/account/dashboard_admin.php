<?php

// UserCake authentication
require_once("../models/config.php");


if (!securePage(__FILE__)){
  // TODO: account section has its own 404 page
  header("Location: index.php");
  exit();
}


setReferralPage(getAbsoluteDocumentPath(__FILE__));

// Admin page

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>phpReports Admin - Admin Dashboard</title>

    <?php require_once("includes.php");  ?>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="../css/typeahead.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap-switch.min.css" type="text/css" />
    
    <!-- Page Specific Plugins -->
	<script src="../js/jquery.tablesorter.js"></script>
	<script src="../js/tables.js"></script>
    <script src="../js/bootstrap-switch.min.js"></script>
 
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
        
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
    
    <script src="../js/raphael/2.1.0/raphael-min.js"></script>
    <script src="../js/morris/morris-0.4.3.js"></script>
    <script src="../js/morris/chart-data-morris.js"></script>
    <script>
        $(document).ready(function() {          
          // Load the header
          $('.navbar').load('header.php', function() {
            $('.navitem-dashboard-admin').addClass('active');
          });

          alertWidget('display-alerts');
          
          // Initialize the transactions tablesorter
          $('#transactions .table').tablesorter({
              debug: false
          });
          
        });      
    </script>
  </body>
</html>
