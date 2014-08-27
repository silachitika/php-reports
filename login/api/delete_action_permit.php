<?php

require_once("../models/config.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// Delete an action-permit mapping, specified by action_id
// POST: action_id, type = (user, group)

$validator = new Validator();
$action_id = $validator->requiredPostVar('action_id');
$type = $validator->requiredPostVar('type');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

//Forms posted
if($action_id && $type) {
	if ($type == "user"){
	  if (!deleteUserActionPermit($action_id)){
		echo json_encode(array("errors" => 1, "successes" => 0));
		exit();
	  } 
	} else if ($type == "group"){
	  if (!deleteGroupActionPermit($action_id)){
		echo json_encode(array("errors" => 1, "successes" => 0));
		exit();
	  } 
	} else {
	  addAlert("danger", "Invalid action type (user, group) specified.");
	  echo json_encode(array("errors" => 1, "successes" => 0));
	  exit();
	}
} else {
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
