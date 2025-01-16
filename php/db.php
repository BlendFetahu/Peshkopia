<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Lidhja
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}
?>