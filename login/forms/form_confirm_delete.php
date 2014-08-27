<?php

require_once("../models/config.php");

if (!securePage(__FILE__)){
  // Forward to index page
  addAlert("danger", "Whoops, looks like you don't have permission to view that page.");
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

$validator = new Validator();

// Request method: GET box_id, title, message, confirm
$box_id = $validator->requiredGetVar('box_id');
$title = $validator->requiredGetVar('title');
$message = $validator->requiredGetVar('message');
$confirm = $validator->requiredGetVar('confirm');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

if (count($validator->errors) > 0){
  echo json_encode(array("errors" => 1, "successes" => 0));
  exit();
}

$response = "
<div id='$box_id' class='modal fade'>
  <div class='modal-dialog modal-sm'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title'>$title</h4>
      </div>
      <div class='modal-body'>
        <div class='dialog-alert'>
        </div>
        <h4>$message<br><small>This action cannot be undone.</small></h4>
        <br>
        <div class='btn-group-action'>
          <button type='button' class='btn btn-danger btn-lg btn-block btn-confirm-delete'>$confirm</button>
          <button type='button' class='btn btn-default btn-lg btn-block' data-dismiss='modal'>Cancel</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
";

echo json_encode(array("data" => $response), JSON_FORCE_OBJECT);
