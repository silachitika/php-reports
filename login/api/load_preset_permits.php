<?php

require_once("../models/config.php");

set_error_handler('logAllErrors');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access this resource.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

// Load a list of preset permit options
// POST: [fields]

$validator = new Validator();
$fields = $validator->optionalGetArray('fields');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

if (count($validator->errors) > 0){
    echo json_encode(array("errors" => 1, "successes" => 0));
    exit();
}

if (!$results = loadPresetPermitOptions($fields)){
    echo json_encode(array("errors" => 1, "successes" => 0));
    exit();
}

echo json_encode($results);

?>