<?php

class Validate {
	private $_passed = false, $_errors = array(), $_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = (isset($source[$item])) ? trim($source[$item]) : 0;
				$item = escape($item);

				if ($rule == 'required' && empty($value)) {
					if ($item == 'password_again')
						$item = 'Repeat Password';
					$this->addError(ucwords($item) . ' is required');
				} else if ( ! empty($value)) {
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value)
								$this->addError(ucwords($item) . " must be a minimum of {$rule_value} characters");
							break;
						case 'max':
							if (strlen($value) > $rule_value)
								$this->addError(ucwords($item) . " must be a maximum of {$rule_value} characters");
							break;
						case 'matches':
							if ($item == 'password_again')
								$item = 'Repeat Password';
							if ($value != $source[$rule_value])
								$this->addError(ucwords($rule_value) . ' must match ' . ucwords($item));
							break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));

							if ($check->count())
								$this->addError("{$item} already exists");
							break;
						default:
							break;
					}
				}
			}
		}

		if (empty($this->_errors))
			$this->_passed = true;

		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}
