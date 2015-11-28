<?php
$xmlLocation = "../xml/testClass.xml";
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
$footer = "?>";

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


print "Write attribute\n";
foreach($class->attributes->attribute as $attribute){
	print "\tAtribute: ".trim($attribute->name)."\n";
	$name = trim($attribute->name);
	if($attribute->init_value){
		print "\t\tInitial value: ".trim($attribute->init_value)."\n";
		$name .= "=".trim($attribute->init_value).";\n";	
	}else{
		$name .= "="."\"\";\n";
	}
	fwrite($outputFile,$name);
}

print "Write method\n";
foreach($class->methods->method as $method){
	print "\tMethod: ".trim($method->name)."\n";
	$method_name = trim($method->name);
	fwrite($outputFile,write_function($method_name, json_decode(json_encode($method->params->param),TRUE)));
}

print "Write footer\n";
fwrite($outputFile, $footer);
fclose($outputFile);

function write_function($name, $attributes){
<<<<<<< HEAD
=======
	print_r($attributes);
>>>>>>> 88832627dd730e35636fc322b379bfebd5900685
	$result = "function __construct";
	if($attributes){
		$result .= "(";
			if(is_array($attributes)){
<<<<<<< HEAD
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
		$result .= "){\n";
		$result .= "\n}\n";
=======
				foreach($attributes as $attribute){
					$result .= "$".trim($attribute);
				}
			}
		$result .= "){";
		$result .= "}\n";
>>>>>>> 88832627dd730e35636fc322b379bfebd5900685
	}
	return $result;
}
?>