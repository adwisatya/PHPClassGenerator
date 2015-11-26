<?php
$xmlLocation = "../xml/testClass.xml";
$outputLocation = "../template/";

$class=simplexml_load_file($xmlLocation) or die("Error: Cannot create object");

if($class->name){
	$outputLocation .= trim($class->name);
	$outputLocation .= ".php";
}else{
	die("Nama class tidak didefinisikan");
}

$outputFile = fopen($outputLocation,"a");

// preparing header and footer//
$header = "<?php\n";
$footer = "?>";

// writing //
fwrite($outputFile,$header);

// if($class->attributes){
// 	$attributes = $class->attribute;

// }
foreach($class->attributes->attribute as $attribute){
	print_r($attribute);
	$name = trim($attribute->name);
	$name .= "="."\"\";\n";
	fwrite($outputFile,$name);
}
fwrite($outputFile, $footer);
fclose($outputFile);

function update_template($location, $var, $value){

}

?>