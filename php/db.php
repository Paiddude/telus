<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username =  "jobdata";
$password = "iv8mZWUsuC8w16NH";
$dbname = "applicantinformation";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



?>