<?php
require_once("../models/config.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

if (!$results = loadPermissionValidators()){
    echo json_encode(array("errors" => 1, "successes" => 0));
    exit();
}

echo json_encode($results);

?>