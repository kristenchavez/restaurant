<?php
$host = "localhost";
$user = "root";
$password = "kristenchavez";
$database = "restaurant_reservations";

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo "Connected successfully!";
?>
