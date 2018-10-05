<?php

// SETTINGS
//CSV file location
$set_location = 'test_csv_22.csv';

// validation table data
// tip when validation data is false and you push it into database some errors will pop up
$set_validation = true;

// push validated data to database
$set_dbpush = false;

// database settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "skillheroes";

// debug message and print_r checks
$debug_message = true;

//=========================================

// Define Variables
$error_array = array();
$i = 0;
$file = file($set_location);

/* Functies voor validatie van csv data */
//Controleer een email adres op geldigheid
function is_email($Invoer)
{
    return (bool)(preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^",$Invoer));
}
//Controleer de lengte van een veld
function is_minlength($Invoer, $MinLengte)
{
    return (strlen($Invoer) >= (int)$MinLengte);
}
//Controleer of NL postcode
function is_NL_PostalCode($Invoer)
{
    return (bool)(preg_match('#^[1-9][0-9]{3}\h*[A-Z]{2}$#i', $Invoer));
}
// Controleert of invoer een NL telefoonnr is
function is_NL_Telnr($Invoer)
{
    return (bool)(preg_match('#^0[1-9][0-9]{0,2}-?[1-9][0-9]{5,7}$#', $Invoer)
        && (strlen(str_replace(array('-', ' '), '', $Invoer)) == 10));
}
// Controleert of invoer alleen uit letters bestaat
function is_Char_Only($Invoer)
{
    return (bool)(preg_match("/^[a-zA-Z ]*$/", $Invoer)) ;
}

// make PDO connection
// try the connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($debug_message == true){
        // Connection Confirmed!
        echo "<b># Database Connection confirmed! </b><br />";
    }
}
// print the try error
catch(PDOException $error)
{
    if($debug_message == true) {
        // Connection failed!
        echo "<b># Database Connection failed: </b>" . $error->getMessage() . "<br />";
    }
}

// Read and Validate the csv data
foreach ($file as &$line) {
    // Filter tabel names push it in a array $tabel_names
    if ($i == 0){
        $tabel_names_array = explode(';', $line);
        $tabelcount = 0;
        foreach ($tabel_names_array as &$tablename) {
            $tabel_names[$tabelcount] = $tablename;
            $tabelcount ++;
        }
    }
    else {
        // divide the line and put it in an array
        $line_data = explode(';', $line);

        // Get data
        $voornaam       = $line_data[0];
        $achternaam     = $line_data[1];
        $telefoon       = $line_data[2];
        $adres          = $line_data[3];
        $iets_anders    = $line_data[4];

        // validate the data
        // set all errors detections to false
        $check_on_errors = false;
        // clear error line array
        $error_details = $i.' ,';

        // empty
        if (empty($voornaam)|| empty($achternaam)|| empty($telefoon)|| empty($adres)|| empty($iets_anders)){
            $check_on_errors = true;
            $error_details .= 'validate error = empty, ';
        }
        //


        // Check voor errors
        if($check_on_errors == true)
        {
            // push error array
            $error_array = array_merge($error_array, array("$error_details"=>"$line"));
        }
        else
        {
            // Push database
        }

        $Data[$i] = $line_data;

    }
    $i++;
}
echo "<pre>";
print_r($error_array);
echo "</pre>";