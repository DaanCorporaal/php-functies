<?php

    $i = 0;
    $file = file('test_csv_2.csv');
    foreach ($file as &$line) {

        $check = explode(';', $line);
        $Data[$i] = $check;


        $parameters = array(':Voornaam' => $Data[$i][0], ':Achternaam' => $Data[$i][1], ':Telefoonnummer' => $Data[$i][2], ':Adres' => $Data[$i][3]);

        $sth = $pdo->prepare("INSERT INTO `$table` (Voornaam, Achternaam, Telefoonnummer, Adres) VALUES (:Voornaam, :Achternaam, :Telefoonnummer, :Adres)");
        $sth->execute($parameters);
        $i++;
        // zet alles in de tabel
        echo "<pre>";
        print_r($sth->errorInfo());
        print_r($parameters);
        echo "</pre>";
        // laat zien of alles goed gaat
    }
    $sql = "DELETE FROM `$table` WHERE Telefoonnummer=0";
    $pdo->exec($sql);
    // als de bovenste regel van het csv bestand bestaat uit voornaam, achternaam e.d. haalt dit het weg
    echo $Data[0][0];


