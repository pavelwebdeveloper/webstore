<?php

/* 
 * Database connections
 */
function onlineStoreConnect() {
$server = "localhost";
$database = "online-store2";
$user = "root";
$password = "";
$dsn = 'mysql:host=' . $server . ';dbname=' . $database;
$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
// Create the actual connection object and assign it to a variable
try {
 $acmeLink = new PDO($dsn, $user, $password, $options);
 /* echo '$acmeLink worked successfully<br>';*/
 return $acmeLink;
} catch (PDOException $exc) {
 //header('location: /phpprojects/acme/view/500.php');
    
    echo "Connection with database did not work out!!!!!!!!!!!!!!!!!";
 exit;
}
}

onlineStoreConnect();