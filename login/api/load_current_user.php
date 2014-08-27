<?php
include('../models/db-settings.php');
include('../models/config.php');

// Fetch information for currently logged in user
// Parameters: none
	
set_error_handler('logAllErrors');

try {		
	// Check that there is a logged-in user
	$user_id = null;
	if(isUserLoggedIn()) {
		$user_id = $loggedInUser->user_id;
	} else {
		addAlert("danger", "Whoops, looks like you're not logged in!");
		echo json_encode(array("errors" => 1, "successes" => 0));
		exit();
	}
	
	$results = fetchUser($user_id);
	
	$results['csrf_token'] = $loggedInUser->csrf_token;
	
} catch (ErrorException $e) {
  addAlert("danger", "Oops, looks like our server might have goofed.  If you're an admin, please check the PHP error logs.");
} catch (RuntimeException $e) {
  addAlert("danger", "Oops, looks like our server might have goofed.  If you're an admin, please check the PHP error logs.");
  error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
} 

restore_error_handler();

echo json_encode($results);
?>