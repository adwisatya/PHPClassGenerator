<?php

class cobain {

	// ATTRIBUTES
	private $var1;

	// CONSTRUCTOR
	public function __constructor() {
		$var1=12;
	}

	// GETTER AND SETTER
	public function get_var1() {
		return var1;
	}
	public function set_var1($param) {
		$var1=$param;
	}

	// METHODS
	public function coba($param) {
		foreach($class->methods->method as $method){
		print "\tMethod: ".trim($method->name)."\n";
		$method_name = trim($method->name);
		$method_code = trim($method->code);
		if($method->code){
			fwrite($outputFile,write_function($method_name, json_decode(json_encode($method->params->param),TRUE),$method_code));
		}else{
			fwrite($outputFile,write_function($method_name,json_decode(json_encode($method->params->param),TRUE),""));
		}
	}
	}

}

?>