<?php
// This Page To Connect Database
//  $dsn = 'mysql:host=localhost;dbname=db6bf3uyuncv84'; // Database Info (Host + database name)
//  $username = 'uvbtyu7p6qt48';
//  $password = 'p5b#kfl223#%';
//  $options = array (
//     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
//  );

$dsn = 'mysql:host=localhost;dbname=zlkwt'; // Database Info (Host + database name)
$username = 'root';
$password = '';
$options = array (
   PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dsn, $username, $password, $options);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }


catch (PDOException $e) { // This Function Appear When Not Connect database
    echo 'Fail To Connect' . $e->getMessage();
}



