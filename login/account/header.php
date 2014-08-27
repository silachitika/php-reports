<?php

// Request method: GET

include('../models/config.php');

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", "You must be logged in to access the account page.");
  header("Location: ../login.php");
  exit();
}

$hooks = array(
		  "#USERNAME#" => $loggedInUser->username,
		  "#WEBSITENAME#" => $websiteName
		  );

// Special case for root account
if ($loggedInUser->user_id == $master_account){
	$hooks['#HEADERMESSAGE#'] = "<span class='navbar-center navbar-brand'>YOU ARE CURRENTLY LOGGED IN AS ROOT USER</span>";
}

echo fetchUserMenu($loggedInUser->user_id, $hooks);

?>


