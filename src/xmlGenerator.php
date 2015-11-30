<?php
	/**
	 * xml Generator: membangkitkan file xml yang berisi masukan dari pengguna berupa atribut dan fungsi untuk sebuah kelas
	 *
	 * @var        DomDocument
	 */
	$xml = new DomDocument("1.0","UTF-8");

	// inisiasi jumlah variabel
	$nbAttr = 3;
	$nbMethod = 4;
	$nbParam = array(1,2,1,2);

	// create xml
	$class = $xml->createElement("class");
	$class = $xml->appendChild($class);
	$name = $xml->createElement("name", "testClass");
	$name = $class->appendChild($name);
	$attributes = $xml->createElement("attributes");
	$attributes = $class->appendChild($attributes);
	for ($i=0; $i<$nbAttr; $i++) { 
		$attribute = $xml->createElement("attribute");
		$attribute = $attributes->appendChild($attribute);
		$attrName = $xml->createElement("name","attr".$i);
		$attrName = $attribute->appendChild($attrName);
		$attrValue = $xml->createElement("value","value".$i);
		$attrValue = $attribute->appendChild($attrValue);
	}
	$methods = $xml->createElement("methods");
	$methods = $class->appendChild($methods);
	for ($i=0; $i<$nbMethod; $i++) { 
		$method = $xml->createElement("method");
		$method = $methods->appendChild($method);
		$methodName = $xml->createElement("name","method".$i);
		$methodName = $method->appendChild($methodName);
		$arguments = $xml->createElement("params");
		$arguments = $method->appendChild($arguments);
		for($j=0; $j<$nbParam[$i]; $j++) {
			$param = $xml->createElement("param","param".$j);
			$param = $arguments->appendChild($param);
		}
	}
	$xml->FormatOutput = true;
	$xml->preserveWhiteSpace = false;
	$save = $xml->saveXML();
	$xml->save("../xml/generatedClass.xml");
?>