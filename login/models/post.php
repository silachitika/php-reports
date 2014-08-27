<?php

$token = security($_POST["csrf_token"]);
if(empty($token))
{
	$errors[] = "a security error occured. please try again";//we know the token is missing, but we don't let the end user know that.
}else{
	if(!$loggedInUser->csrf_validate($token))
	{
		$errors[] = "a security error occured. please try again.";//the token was wrong, but same here.
	}
}

/*
basic usage

class:
$loggedInUser->csrf_token(true); <-- creates the token

$loggedInUser->csrf_token; <-- accesses the token from its storage in the session object

$loggedInUser->csrf_validate(); <-- validates and regenerates the token

form_protect($loggedInUser->csrf_token); <--inserts the hidden form value and users token inside of a form element where ever its called

require_once 'models/post.php; <--includes this file in the page you need to validate user inputted data.

be sure to require once after the $errors = array(); has already been set in the form processing script.

this token system should only be used on forms where a user is logged in. it does no good on register or login.

*/