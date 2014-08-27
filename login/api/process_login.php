<?php
// Request method: POST

require_once("../models/config.php");

set_error_handler('logAllErrors');

// Publically accessible API

//Forward the user to their default page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("warning", "You're already logged in!");
  if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
	echo json_encode(array("errors" => 1, "successes" => 0));
  } else {
	header("Location: account.php");
  }
	exit();
}
$validate = new Validator();

$postedUsername = str_normalize($validate->requiredPostVar('username'));
//Forms posted
if(!empty($_POST))
{
    global $email_login;

    $isEmail = count(explode('@', $postedUsername));

    if ($isEmail == 2 && $email_login == 1) {
        $email = 1;
        $email_address = $postedUsername;
    } elseif ($isEmail == 1 && $email_login == 1){
        $email = 0;
        $username = $postedUsername;
    }else {// ($email_login == 0){
        $email = 0;
        $username = $postedUsername;
    }

	$errors = array();
	$password = $validate->requiredPostVar('password');
	
	//Perform some validation
	//Feel free to edit / change as required
    if ($email == 1){
        if($email_address == "")
        {
            $errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
        }
    } else {
        if($username == "")
        {
            $errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
        }
    }
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}
	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
        if($email == 1){
            $existsVar = !emailExists($email_address);
        }else{
            $existsVar = !usernameExists($username);
        }

        if($existsVar)
		{
		  	$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
		}
        else
		{
            if ($email == 1){
                $userdetails = fetchUserAuthByEmail($email_address);
            } elseif ($email == 0) {
                $userdetails = fetchUserAuthByUserName($username);
            }
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			// See if user's account is enabled
			else if ($userdetails["enabled"]==0){
				$errors[] = lang("ACCOUNT_DISABLED");
			} else {
				// Validate the password
				if(!passwordVerifyUF($password, $userdetails["password"]))
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				} else {
					//Passwords match! we're good to go'
					
					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->displayname = $userdetails["display_name"];
					$loggedInUser->username = $userdetails["user_name"];
					$loggedInUser->alerts = array();
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					
					// Update password if we had encountered an outdated hash
					if (getPasswordHashTypeUF($userdetails["password"]) != "modern"){
					    // Hash the user's password and update
						$password_hash = passwordHashUF($password);
						if ($password_hash === null){
							error_log("Notice: outdated password hash could not be updated because new hashing algorithm is not supported.  Are you running PHP >= 5.3.7?");
						} else {
							$loggedInUser->hash_pw = $password_hash;
							updateUserField($loggedInUser->user_id, 'password', $password_hash);
							error_log("Notice: outdated password hash has been automatically updated to modern hashing.");
						}
					}
					
					// Create the user's CSRF token
					$loggedInUser->csrf_token(true);
					
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					$successes = array();
					$successes[] = "Welcome back, " . $loggedInUser->displayname;
				}
			}
		}
	}
} else {
	$errors[] = lang("NO_DATA");
}

restore_error_handler();

foreach ($errors as $error){
  addAlert("danger", $error);
}
foreach ($successes as $success){
  addAlert("success", $success);
}

if (isset($_POST['ajaxMode']) and $_POST['ajaxMode'] == "true" ){
  echo json_encode(array(
	"errors" => count($errors),
	"successes" => count($successes)));
} else {
  // Always redirect to login page on error
  if (count($errors) > 0)
	header('Location: login.php');
  else
	header('Location: ../../');
  exit();
}
