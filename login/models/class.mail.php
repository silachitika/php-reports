<?php
// This is a hack to handle warnings and errors that may not be reflected in the return value of mail()
function emailErrorHandler($errno, $errstr, $errfile, $errline) {
    global $emailSuccessState;
	$emailSuccessState = false;
    /* Don't execute PHP internal error handler */
    return true;
}

class userCakeMail {
	//UserCake uses a text based system with hooks to replace various strs in txt email templates
	public $contents = NULL;
	
	//Function used for replacing hooks in our templates
	public function newTemplateMsg($template,$additionalHooks)
	{
		global $debug_mode;
		
		$this->contents = file_get_contents(MAIL_TEMPLATES.$template);
		
		//Check to see we can access the file / it has some contents
		if(!$this->contents || empty($this->contents)) {
			return false;
		} else {
			//Replace default hooks
			$this->contents = replaceDefaultHook($this->contents);
			
			//Replace defined / custom hooks
			$this->contents = str_replace($additionalHooks["searchStrs"],$additionalHooks["subjectStrs"],$this->contents);
			
			return true;
		}
	}
	
	public function sendMail($email,$subject,$msg = NULL)
	{
		global $websiteName,$emailAddress,$emailSuccessState;
		
		$header = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$header .= "From: ". $websiteName . " <" . $emailAddress . ">\r\n";
		
		//Check to see if we sending a template email.
		if($msg == NULL)
			$msg = $this->contents; 
		
		$message = $msg;
		
		$message = wordwrap($message, 70);
		
		$emailSuccessState = true;
		set_error_handler("emailErrorHandler");
		$success = mail($email,$subject,$message,$header);
		restore_error_handler();
		
		return $success && $emailSuccessState;
	}
}

?>