<?php
// This class detects and sanitizes user input from GET or POST requests.
class Validator {
	public $errors;

	function __construct() {
		$this->errors = array();
	}
	
	// TODO: also use strip_tags()?
	
	public function requiredGetVar($varname){
		// Confirm that data has been submitted via GET
		if (!($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$this->errors[] = "Error: data must be submitted via GET.";
			return null;
		}
		
		if (isset($_GET[$varname]))
			return htmlentities($_GET[$varname]);
		else {
			$this->errors[] = "Parameter $varname must be specified!";
			return null;
		}
	}

	public function requiredGetArray($varname){
		// Confirm that data has been submitted via GET
		if (!($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$this->errors[] = "Error: data must be submitted via GET.";
			return null;
		}
		if (isset($_GET[$varname])) {
			$arr = array();
			foreach ($_GET[$varname] as $val){
				$arr[] = htmlentities($val);
			}
			return $arr;
		} else {
			$this->errors[] = "Parameter $varname must be specified!";
			return null;
		}
	}
	
	public function requiredPostVar($varname){
		// Confirm that data has been submitted via POST
		if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->errors[] = "Error: data must be submitted via POST.";
			return null;
		}
	
		if (isset($_POST[$varname]))
			return htmlentities($_POST[$varname]);
		else {
			$this->errors[] = "Parameter $varname must be specified!";
			return null;
		}
	}

	public function requiredPostArray($varname){
		// Confirm that data has been submitted via POST
		if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->errors[] = "Error: data must be submitted via POST.";
			return null;
		}
		if (isset($_POST[$varname])) {
			$arr = array();
			foreach ($_POST[$varname] as $val){
				$arr[] = htmlentities($val);
			}
			return $arr;
		} else {
			$this->errors[] = "Parameter $varname must be specified!";
			return null;
		}
	}
	
	public function requiredNumericPostVar($varname){
		// Confirm that data has been submitted via POST
		if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->errors[] = "Error: data must be submitted via POST.";
			return null;
		}
		
		if (isset($_POST[$varname]) && is_numeric($_POST[$varname]))
			return htmlentities($_POST[$varname]);
		else
			return null;
	}
	
	public function optionalGetVar($varname){
		// Confirm that data has been submitted via GET
		if (!($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$this->errors[] = "Error: data must be submitted via GET.";
			return null;
		}
		
		if (isset($_GET[$varname]))
			return htmlentities($_GET[$varname]);
		else
			return null;
	}
	
	public function optionalNumericGetVar($varname){
		// Confirm that data has been submitted via GET
		if (!($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$this->errors[] = "Error: data must be submitted via GET.";
			return null;
		}
		
		if (isset($_GET[$varname]) && is_numeric($_GET[$varname]))
			return htmlentities($_GET[$varname]);
		else
			return null;
	}	
	
	public function optionalPostVar($varname){
		// Confirm that data has been submitted via POST
		if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->errors[] = "Error: data must be submitted via POST.";
			return null;
		}
		if (isset($_POST[$varname]))
			return htmlentities($_POST[$varname]);
		else
			return null;
	}	

	public function optionalPostArray($varname){
		// Confirm that data has been submitted via POST
		if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->errors[] = "Error: data must be submitted via POST.";
			return null;
		}
		if (isset($_POST[$varname])) {
			$arr = array();
			foreach ($_POST[$varname] as $val){
				$arr[] = htmlentities($val);
			}
			return $arr;
		} else {
			return array();
		}
	}		

	public function optionalGetArray($varname){
		// Confirm that data has been submitted via GET
		if (!($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$this->errors[] = "Error: data must be submitted via GET.";
			return null;
		}
		if (isset($_GET[$varname])) {
			$arr = array();
			foreach ($_GET[$varname] as $val){
				$arr[] = htmlentities($val);
			}
			return $arr;
		} else {
			return array();
		}
	}
	
	// Optional boolean variable ("true" or "false" as string)
	function optionalBooleanGetVar($var_name, $default_value = "false"){
		// Confirm that data has been submitted via GET
		if (!($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$this->errors[] = "Error: data must be submitted via GET.";
			return null;
		}
		
		if (isset($_GET[$var_name])){
			$bool_val = false;
			if (strtolower($_GET[$var_name]) == "true")
				$bool_val = true;
			if ($bool_val == $default_value)
				return $default_value;
			else
				return !$default_value;
		} else
			return $default_value;
	}	

	// Optional boolean variable ("true" or "false" as string)
	function optionalBooleanPostVar($var_name, $default_value = "false"){
		// Confirm that data has been submitted via POST
		if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$this->errors[] = "Error: data must be submitted via POST.";
			return null;
		}
		
		if (isset($_POST[$var_name])){
			$bool_val = false;
			if (strtolower($_POST[$var_name]) == "true")
				$bool_val = true;
			if ($bool_val == $default_value)
				return $default_value;
			else
				return !$default_value;
		} else
			return $default_value;
	}	
}

?>