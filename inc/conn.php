<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $conn = mysqli_connect('localhost' , 'root' , '' , 'batch');
    
$servername = "localhost";
$username = "root";
$password = "";

try {
  $con = new PDO("mysql:host=$servername;dbname=batch", $username, $password);
  // set the PDO error mode to exception
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>