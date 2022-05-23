<?php

$serverName = "localhost:3307";
$userName = "root";
$password = "";
$databaseName = "demo2";

// Create connection

try{
    $con = new PDO("mysql:host=$serverName;dbname=$databaseName", $userName, $password);

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}