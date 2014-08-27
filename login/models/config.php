<?php
// Used to force backend scripts to log errors rather than print them as output
function logAllErrors($errno, $errstr, $errfile, $errline, array $errcontext) {
	ini_set("log_errors", 1);
	ini_set("display_errors", 0);
	
    error_log("Error ($errno): $errstr in $errfile on line $errline");
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

require_once("db-settings.php"); //Require DB connection
require_once("funcs.php");
require_once("password.php");
require_once("db_functions.php");

//Retrieve basic configuration settings

$settings = fetchConfigParameters();

//Set Settings
$emailActivation = $settings['activation'];
$can_register = $settings['can_register'];
$websiteName = $settings['website_name'];
$websiteUrl = $settings['website_url'];
$emailAddress = $settings['email'];
$resend_activation_threshold = $settings['resend_activation_threshold'];
$emailDate = date('dmy');
$language = $settings['language'];
$template = $settings['template'];
$new_user_title = $settings['new_user_title'];
$email_login = $settings['email_login'];
$token_timeout = $settings['token_timeout'];

// Determine if this is SSL or unsecured connection
$url_prefix = "http://";
// Determine if connection is http or https
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    // SSL connection
	$url_prefix = "https://";
}

// Define paths here
defined("SITE_ROOT")
    or define("SITE_ROOT", $url_prefix.$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/');

defined("LOCAL_ROOT")
	or define ("LOCAL_ROOT", realpath(dirname(__FILE__)."/.."));
	
defined("MENU_TEMPLATES")
    or define("MENU_TEMPLATES", dirname(__FILE__) . "/menu-templates/");

defined("MAIL_TEMPLATES")
	or define("MAIL_TEMPLATES", dirname(__FILE__) . "/mail-templates/");

defined("FILE_SECURE_FUNCTIONS")
	or define("FILE_SECURE_FUNCTIONS", dirname(__FILE__) . "/secure_functions.php");	

// Include paths for pages to add to site page management
$page_include_paths = array(
	"account",
	"forms"
	// Define more include paths here
);
	
// This is the user id of the master (root) account.
// The root user cannot be deleted, and automatically has permissions to everything regardless of group membership.
$master_account = 1;

$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
$default_replace = array($websiteName,SITE_ROOT,$emailDate);

// The dirname(__FILE__) . "/..." construct tells PHP to look for the include file in the same directory as this (the config) file
if (!file_exists($language)) {
	$language = dirname(__FILE__) . "/languages/en.php";
}

if(!isset($language)) $language = dirname(__FILE__) . "/languages/en.php";

function getAbsoluteDocumentPath($localPath){
	return SITE_ROOT . getRelativeDocumentPath($localPath);
}

// Return the document path of a file, relative to the root directory of the site.  Takes the absolute local path of the file (such as defined by __FILE__)
function getRelativeDocumentPath($localPath){
	// Replace backslashes in local path (if we're in a windows environment)
	$localPath = str_replace('\\', '/', $localPath);
	
	// Get lowercase version of path
	$localPathLower = strtolower($localPath);

	// Replace backslashes in local root (if we're in a windows environment)
	$localRoot = str_replace('\\', '/', LOCAL_ROOT);	
	
	// Get lowercase version of path
	$localRootLower = strtolower($localRoot) . "/";
	
	// Remove local root but preserve case
	$pos = strpos($localPathLower, $localRootLower);
	if ($pos !== false) {
		return substr_replace($localPath,"",$pos,strlen($localRootLower));
	} else {
		return $localRoot;
	}
}

//Pages to require
require_once($language);
require_once("class_validator.php");
require_once("authorization.php");
require_once("secure_functions.php");
require_once("class.mail.php");
require_once("class.user.php");

//ChromePhp debugger for chrome console
// http://craig.is/writing/chrome-logger
//require_once("chrome.php");

session_start();

//Global User Object Var
//loggedInUser can be used globally if constructed
if(isset($_SESSION["userCakeUser"]) && is_object($_SESSION["userCakeUser"]))
{
	$loggedInUser = $_SESSION["userCakeUser"];
}

?>
