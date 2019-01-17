<?php
class Validate { //class variables
	private $_passed = false, 	//whether variable is passed
			$_errors = array(),	//errors if there's any
			$_db = null; 		//database

	public function __construct() { //construct db
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) { //check function 
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {

					$value = trim($source[$item]);
					$item = escape($item);

					if($rule === 'required' && empty($value)) {
						$this->addError("{$item} is Required"); //produces error such as ({password} is required)
					} else if(!empty($value)) {
						switch($rule) { //switch case

							case 'min':
								if(strlen($value) < $rule_value) {
									$this->addError("{$item} must be a minimum of {$rule_value} characters.");
								}
							break;
							case 'max':
								if(strlen($value) > $rule_value) {
									$this->addError("{$item} must be a maximum of {$rule_value} characters.");
								}
							break;
							case 'matches':
								if($value != $source[$rule_value]) { //value is not available in source loop hence need to specify
									$this->addError("{$rule_value} must match {$item}");
								}
							break;
							case 'unique':
								$check = $this->_db->get($rule_value, array($item, '=', $value));
								if($check->count()) {
									$this->addError("{$item} already exists.");
								}
							break;

						}
					}

			}
		}

		if(empty($this->_errors)) { 	//pass the passed check if no errors
			$this->_passed = true;
		}

		return $this;
	}

	private function addError($error) { //load up errors if theres error
		$this->_errors[] = $error;
	}

	public function errors() { 			//pushes to error variable
		return $this->_errors;
	}

	public function passed() { 			//pushes to pass variable
		return $this->_passed;
	}
}