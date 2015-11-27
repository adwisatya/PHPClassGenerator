<?php
	$xml = new DomDocument("1.0","UTF-8");

	$class = $xml->createElement("class");
	$class = $xml->appendChild($class);
	$name = $xml->createElement("name", "testClass");
	$name = $class->appendChild($name);
	$attributes = $xml->createElement("attributes");
	$attributes = $class->appendChild($attributes);
	for ($i=0; $i < 5; $i++) { 
		$attribute = $xml->createElement("attribute");
		$attribute = $attributes->appendChild($attribute);
		$attrName = $xml->createElement("name","attr".$i);
		$attrName = $attribute->appendChild($attrName);
		$attrValue = $xml->createElement("value","value".$i);
		$attrValue = $attribute->appendChild($attrValue);
	}
	$methods = $xml->createElement("methods");
	$methods = $class->appendChild($methods);
	for ($i=0; $i < 5; $i++) { 
		$method = $xml->createElement("method".$i);
		$method = $methods->appendChild($method);
		$methodName = $xml->createElement("name","method".$i);
		$methodName = $method->appendChild($methodName);
		$methodValue = $xml->createElement("operation","operation".$i);
		$methodValue = $method->appendChild($methodValue);
	}
	$xml->FormatOutput = true;
	$save = $xml->saveXML();
	$xml->save("../xml/generatedClass.xml");
?>