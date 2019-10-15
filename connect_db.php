<?php
session_start();
$host = "localhost";
$userName = "batung";
$password = "batung!@98";
$dbName = "demo_phpbase";
$dsn = "mysql:host=$host;dbname=$dbName";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $conn = new PDO($dsn, $userName, $password,$options);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}