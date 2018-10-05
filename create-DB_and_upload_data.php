<form action="" method="post">
   Naam van de school <input type="text" name="naam"> <br />
    upload csv bestand <input type="file" name="file">
    <input type="submit" name="submit" value="versturen">
</form>


<?php
if (isset($_POST['submit'])) {
    $table = $_POST['naam'];
    $user = 'newuser';
    $pass = 'newpass';
    $db = 'newdb';
    $bestand = $_POST['file'];
    try {
        $pdo = new PDO("mysql:host=localhost", 'root', '');

        $pdo->exec("CREATE DATABASE `$table`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$table`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;")
        or die(print_r($pdo->errorInfo(), true));
        echo "database succesvol gemaakt ";


    } catch (PDOException $e) {
        die("DB ERROR: " . $e->getMessage());
    }
// zorgt ervoor dat de tabel gemaakt wordt

    try {
        $pdo = new PDO("mysql:dbname=$table;host=localhost", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Error Handling
        $sql = "CREATE table $table (
     ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
     Voornaam VARCHAR( 50 ) NOT NULL, 
     Achternaam VARCHAR( 250 ) NOT NULL,
     Telefoonnummer VARCHAR( 150 ) NOT NULL, 
     Adres VARCHAR( 150 ) NOT NULL)";
        $pdo->exec($sql);
        print("Created $table Table.\n");

    } catch (PDOException $e) {
        echo $e->getMessage();//Remove or change message in production code
    }

// maakt de tabel


    $i = 0;
    $file = file($bestand);
    foreach ($file as &$line) {
        $bob = explode(';', $line);
        $karel[$i] = $bob;
// leest de csv file

        $parameters = array(':Voornaam' => $karel[$i][0], ':Achternaam' => $karel[$i][1], ':Telefoonnummer' => $karel[$i][2], ':Adres' => $karel[$i][3]);

        $sth = $pdo->prepare("INSERT INTO `$table` (Voornaam, Achternaam, Telefoonnummer, Adres) VALUES (:Voornaam, :Achternaam, :Telefoonnummer, :Adres)");
        $sth->execute($parameters);
        $i++;
        // vult de tabel in
        echo "<pre>";
        print_r($sth->errorInfo());
        print_r($parameters);
        echo "</pre>";
    }
    // laat eventuele error messages zien
    $sql = "DELETE FROM `$table` WHERE Telefoonnummer=0";

    $pdo->exec($sql);
    // als de bovenste regel van het csv bestand bestaat uit voornaam, achternaam e.d. haalt dit het weg
    echo $karel[0][0];
}

