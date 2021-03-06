<?php
$xmlLocation = "../xml/generatedClass.xml";
$outputLocation = "../template/";

print "Inisiasi\n";
$class=simplexml_load_file($xmlLocation) or die("Error: Cannot create object");

if($class->name){
	$outputLocation .= trim($class->name);
	$outputLocation .= ".php";
}else{
	die("Nama class tidak didefinisikan");
}

// preparing header and footer//
$header = "<?php\n";
$header .= "\nclass ".trim($class->name)." {\n\n";

$footer = "\n}\n";
$footer .= "\n?>";


// writing //
print "\tCreating ".$outputLocation."\n";
if(file_exists($outputLocation)){
	try{
		unlink($outputLocation);
		print "\tDelete existing file ".$outputLocation."\n";
	}catch(Exception $e){
		print "\t\tFailed to delete existing file\n";
	}
}
$outputFile = fopen($outputLocation,"a");

print "Write header\n";
fwrite($outputFile,$header);

if($class->attributes){
	print "Write attribute\n";
	$name = "\t// ATTRIBUTES\n";
	fwrite($outputFile,$name);
	foreach($class->attributes->attribute as $attribute){
		print "\tAtribute: ".trim($attribute->name)."\n";
		$name = "\tprivate $".trim($attribute->name).";\n";
		fwrite($outputFile,$name);
	}
	fwrite($outputFile,"\n\t// CONSTRUCTOR\n");
	fwrite($outputFile,write_constructor($class->attributes,""));
	// SETTER AND GETTER
	fwrite($outputFile,"\n\t// GETTER AND SETTER\n");
	foreach($class->attributes->attribute as $attribute){
		print "\tSetter and Getter: ".trim($attribute->name)."\n";
		fwrite($outputFile,write_getter(trim($attribute->name)));
		fwrite($outputFile,write_setter(trim($attribute->name)));
	}
	fwrite($outputFile,"\n");
}
print "Write constructor\n";
if($class->methods){
	print "Write method\n";
	fwrite($outputFile,"\t// METHODS\n");
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
print "Write footer\n";
fwrite($outputFile, $footer);
fclose($outputFile);

function write_constructor($attributes, $param){
	$result = "\tpublic function __constructor($param) {\n\t\t";
	foreach($attributes->attribute as $attribute){
		if($attribute->value!=""){
			$name = "\$this->".trim($attribute->name);
			$name .= "=\"".trim($attribute->value)."\";\n";
			$result.=$name;
		}
	}
	$result .= "\n\t}\n";
	return $result;
}

function write_setter($name){
	$result = "\tpublic function set_".$name;
	$result .= "(\$param) {\n\t\t\$this->".$name."=\$param;";
	$result .= "\n\t}\n";
	return $result;
}

function write_getter($name){
	$result = "\tpublic function get_".$name;
	$result .= "() {\n\t\treturn \$this->".$name.";";
	$result .= "\n\t}\n";
	return $result;
}

function write_function($name, $attributes, $actions) {
	if($name=="") {
		return;
	}
	$result = "\tpublic function ".$name;
	$result .= "(";
	if($attributes){
		if(is_array($attributes)){
			$i = 0;
			$count = count($attributes);
			foreach($attributes as $attribute){
				print("\t\tParameter: ".trim($attribute)."\n");
				if(($i != 0) && ($i != $count)){
					$result .= ",";
				}
				$result .= "$".trim($attribute);
				$i++;
			}
		}
	}
	$result .= ") {\n\t\t";
	$result .= $actions;
	$result .= "\n\t}\n";
	return $result;
}
function write_action($action){
	$result = "\n";
	//print_r($action);
	foreach($action as $act){
		//print_r($act['type']);
		print("\t\tActions: ".trim($act['type'])."\n");
		switch (trim($act['type'])) {

			case 'for':
				$result .= "\t\tfor($"."i=".trim($act['init_value']).";$"."i<=".trim($act['end_value']).";$"."i++) {\n";
				$result .= "\t\t\t//your code\n";
				$result .= "\t\t}\n";
				break;
			case 'while':
				$result .= "\t\twhile(TRUE) {\n";
				$result .= "\t\t\t//your code\n";
				$result .= "\t\t}\n";
				break;
			case 'do_while':
				$result .= "\t\tdo {\n";
				$result .= "\t\t\t//your code\n";
				$result .= "\t\t} while(TRUE);\n";
				break;
			default:

				break;
		}
	}
	return $result;
}
?>