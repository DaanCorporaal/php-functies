<?php

header('Content-Type: text/xml');
$xml = new DOMDocument( "1.0", "UTF-8" );
$xml_root = $xml->createElement('xml','some random data');
$NaamData = $xml->createElement('NaamData');


$xml_Attribute = $xml->createAttribute('name');
$xml_Attribute->value = 'attributevalue';
$xml_root->appendChild($xml_Attribute);

$NaamData_Attribute = $xml->createAttribute('name');
$NaamData_Attribute->value = 'Loop Data';
$NaamData->appendChild($NaamData_Attribute);

$xml->appendChild($xml_root);
$xml_root->appendChild($NaamData);

for ($x = 0; $x <= 3; $x++) {
    ${'Persoon' . $x} = $xml->createElement("Persoon");
    $NaamData->appendChild(${'Persoon' . $x});


    ${'Naam' . $x} = $xml->createElement("Naam");
    ${'Persoon' . $x}->appendChild(${'Naam' . $x});

    ${'Voornaam' . $x} = $xml->createElement("Voornaam","Daan");
    ${'Naam' . $x}->appendChild(${'Voornaam' . $x});

    ${'Achternaam' . $x} = $xml->createElement("Achternaam","Corporaal");
    ${'Naam' . $x}->appendChild(${'Achternaam' . $x});


    ${'Adres' . $x} = $xml->createElement("Adres",'5345');
    ${'Persoon' . $x}->appendChild(${'Adres' . $x});

}

$xml->save("hoi.xml");
print $xml->saveXML();