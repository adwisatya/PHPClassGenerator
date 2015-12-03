<?php

class TestClass {

	// ATTRIBUTES
	private $attr1;

	// CONSTRUCTOR
	public function __constructor() {
		$this->attr1=10;
	}

	// GETTER AND SETTER
	public function get_attr1() {
		return $this->attr1;
	}
	public function set_attr1($param) {
		$this->attr1=$param;
	}

	// METHODS
	public function method1($param1) {
		
	}

}

?>