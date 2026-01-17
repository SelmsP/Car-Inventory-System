<?php
$conn = new mysqli("localhost", "root", "", "car_inventory");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);


session_start();
?>

