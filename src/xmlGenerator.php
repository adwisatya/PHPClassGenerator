<?php
	/**
	 * xml Generator: membangkitkan file xml yang berisi masukan dari pengguna berupa atribut dan fungsi untuk sebuah kelas
	 *
	 * @var        DomDocument
	 */
	$xml = new DomDocument("1.0","UTF-8");
	echo $_POST['test'];
	$str = $_POST['test'];
	$generatedClass = json_decode($str);

	// inisiasi jumlah variabel
	$nbAttr = count($generatedClass->atribut);
	$nbMethod = count($generatedClass->method);
	$nbParam = array(1,2,1,2);

	// create xml
	$class = $xml->createElement("class");
	$class = $xml->appendChild($class);
	$name = $xml->createElement("name", $generatedClass->namaKelas);
	$name = $class->appendChild($name);
	$attributes = $xml->createElement("attributes");
	$attributes = $class->appendChild($attributes);
	for ($i=0; $i<$nbAttr; $i++) { 
		$attribute = $xml->createElement("attribute");
		$attribute = $attributes->appendChild($attribute);
		$attrName = $xml->createElement("name",$generatedClass->atribut[$i]->nama);
		$attrName = $attribute->appendChild($attrName);
		$attrValue = $xml->createElement("value",$generatedClass->atribut[$i]->nilai);
		$attrValue = $attribute->appendChild($attrValue);
	}
	$methods = $xml->createElement("methods");
	$methods = $class->appendChild($methods);
	for ($i=0; $i<$nbMethod; $i++) { 
		$method = $xml->createElement("method");
		$method = $methods->appendChild($method);
		$methodName = $xml->createElement("name",$generatedClass->method[$i]->name);
		$methodName = $method->appendChild($methodName);
		$arguments = $xml->createElement("params");
		$arguments = $method->appendChild($arguments);
		for($j=0; $j<$nbParam[$i]; $j++) {
			$param = $xml->createElement("param",$generatedClass->method[$i]->parameter[$j]);
			$param = $arguments->appendChild($param);
		}
		$code = $xml->createElement("code",$generatedClass->method[$i]->content);
		$code = $method->appendChild($code);
	}
	$xml->FormatOutput = true;
	$xml->preserveWhiteSpace = false;
	$save = $xml->saveXML();
	$xml->save("../xml/generatedClass.xml");
	header("location:Parser.php");
?>