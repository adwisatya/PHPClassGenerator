<?php
$xmlLocation = "../xml/kasus_uji.xml";
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
$footer .= "?>";


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
	foreach($class->attributes->attribute as $attribute){
		print "\tAtribute: ".trim($attribute->name)."\n";
		$name = "\t".trim($attribute->access)." $".trim($attribute->name);
		if($attribute->init_value){
			print "\t\tInitial value: ".trim($attribute->init_value)."\n";
			$name .= "=".trim($attribute->init_value).";\n";	
		}else{
			$name .= "="."\"\";\n";
		}
		fwrite($outputFile,$name);
	}
}
print "Write constructor\n";
	fwrite($outputFile,"\n");
	fwrite($outputFile,write_function("","__constructor","",""));
if($class->methods){
	print "Write method\n";
	foreach($class->methods->method as $method){
		print "\tMethod: ".trim($method->name)."\n";
		$method_name = trim($method->name);
		if($method->actions){
			fwrite($outputFile,write_function(trim($method->access),$method_name, json_decode(json_encode($method->params->param),TRUE),json_decode(json_encode($method->actions),TRUE)));
		}else{
			fwrite($outputFile,write_function(trim($method->access),$method_name,json_decode(json_encode($method->params->param),TRUE),""));
		}
	}
}
print "Write footer\n";
fwrite($outputFile, $footer);
fclose($outputFile);

function write_function($access, $name, $attributes,$actions){
	$result = "public function ".$name;
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
	$result .= "){\n";
	if($actions){
		if(is_array($actions)){
			foreach($actions as $action){
				$result .= write_action($action);
			}
		}
	}
	$result .= "\n}\n";
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
		 		$result .= "\tfor($"."i=".trim($act['init_value']).";$"."i<=".trim($act['end_value']).";$"."i++){\n\n";
		 		$result .= "\t\t//your code\n";
		 		$result .= "\t}\n";
		 		break;
		 	case 'while':
		 		$result .= "\twhile(TRUE){\n";
		 		$result .= "\t\t//your code\n";
		 		$result .= "\t}\n";
		 		break;
		 	case 'do_while':
				$result .= "\tdo{\n";
		 		$result .= "\t\t//your code\n";
		 		$result .= "\t}while(TRUE);\n";
		 		break;
		 	default:
		 		
		 		break;
		 }
	}
	return $result;
}
?>