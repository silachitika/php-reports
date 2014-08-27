<?php

require_once("../models/config.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// Create a new action_permit mapping for a user or group.
// POST: action_name, permit, [user_id, group_id]

$validator = new Validator();
$action_name = $validator->requiredPostVar('action_name');
$permit = $validator->requiredPostVar('permit');
$group_id = $validator->optionalPostVar('group_id');
$user_id = $validator->optionalPostVar('user_id');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

//Forms posted
if($group_id) {
	if (!createGroupActionPermit($group_id, $action_name, $permit)){
	  echo json_encode(array("errors" => 1, "successes" => 0));
	  exit();
	}
} else if ($user_id){
	if (!createUserActionPermit($user_id, $action_name, $permit)){
	  echo json_encode(array("errors" => 1, "successes" => 0));
	  exit();
	}
} else {
	addAlert("danger", "You must specify a user or group id!");
	echo json_encode(array("errors" => 1, "successes" => 0));
	exit();
}

restore_error_handler();

if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
  echo json_encode(array(
	"errors" => 0,
	"successes" => 1));
} else {
  header('Location: ' . getReferralPage());
  exit();
}
?>
