<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change if needed
$dbname = "find_it";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>