<?php
include('../models/db-settings.php');
include('../models/config.php');

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// POST Parameters: user_id
$validator = new Validator();
$user_id = $validator->requiredPostVar('user_id');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

// Cannot delete master account
if ($user_id == $master_account){
	addAlert("danger", lang("ACCOUNT_DELETE_MASTER"));
	echo json_encode(array("errors" => 1, "successes" => 0));
	exit();	
} else {
	// Delete the user entirely.  This action cannot be undone!
	if (deleteUser($user_id)) {
		addAlert("success", lang("ACCOUNT_DELETIONS_SUCCESSFUL", array('1')));
	}
	else {
		echo json_encode(array("errors" => 1, "successes" => 0));
		exit();
	}
}

restore_error_handler();

// Allows for functioning in either ajax mode or graceful degradation to PHP/HTML only  
if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
  echo json_encode(array("errors" => 0, "successes" => 1));
} else {
  header('Location: ' . getReferralPage());
  exit();
}

?>
