<?php
$host = 'localhost';
$username = 'isak';
$password = 'some_pass';
$database = 'mydb';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Tilkobling mislykket: " . $mysqli->connect_error);
}

// lag 'users' tabell hvis den ikke finnes
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.png'
)";

if (!$mysqli->query($sql)) {
    die("Kunne ikke lage ny tabell: " . $mysqli->error);
}
?>
