<?php
// Request method: GET

require_once('../models/config.php');

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// GET Parameters: [user_id, group_id]
// If a user_id is specified, attempt to load action permits explicitly defined for the specified user.
// If a group_id is specified, attempt to load action permits for the specified group.
// Otherwise, attempt to load all action permits for either groups or users.
$validator = new Validator();
$user_id = $validator->optionalGetVar('user_id');
$group_id = $validator->optionalGetVar('group_id');
$all = $validator->optionalGetVar('all');
$pretty = $validator->optionalGetVar('pretty');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

if ($user_id){
  // Special case to load groups for the logged in user
  if ($user_id == "0"){
    $user_id = $loggedInUser->user_id;
  }
  
  // Attempt to load action permits for the specified user.
  if (!($results = loadUserActionPermits($user_id))){
      echo json_encode(array("errors" => 1, "successes" => 0));
      exit();
  }
} else if ($group_id){	
  // Attempt to load action permits for the specified group.
  if (!($results = loadGroupActionPermits($group_id))){
      echo json_encode(array("errors" => 1, "successes" => 0));
      exit();
  }
} else {
  if ($all == "users"){
    // Attempt to load action permits for all users
    if (!($results = loadUserActionPermits("all"))){
        echo json_encode(array("errors" => 1, "successes" => 0));
        exit();
    }
  } else if ($all == "groups"){
    // Attempt to load action permits for all groups
    if (!($results = loadGroupActionPermits("all"))){
        echo json_encode(array("errors" => 1, "successes" => 0));
        exit();
    }
  } else {
    addAlert("danger", "user_id, group_id, or all must be specified.");
    echo json_encode(array("errors" => 1, "successes" => 0));
    exit();    
  }
}

restore_error_handler();

if ($pretty){
  echo prettyPrint(json_encode($results, JSON_PRETTY_PRINT));
} else {
  echo json_encode($results);
}
?>