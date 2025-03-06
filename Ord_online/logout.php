<?php
session_start();
require_once 'database.php';

// Slett session fra databasen hvis token eksisterer
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $sql = "DELETE FROM sessions WHERE token = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
}

// Slett cookie
setcookie("remember_me", "", time() - 3600, "/", "", true, true);

// Destroy session
session_destroy();

header("Location: login.php");
exit;
?>
