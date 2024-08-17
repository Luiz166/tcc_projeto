<?php
$servername = "localhost";
$username = "root";
$passsword = "";
$dbname = "financeapp";

$conn = new mysqli($servername, $username, $passsword, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>