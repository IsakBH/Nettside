<?php
session_start();
require_once '../database.php';

// slett session fra databasen hvis cookie eksisterer
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $sql = "DELETE FROM sessions WHERE token = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
}

// slett cookie
setcookie("remember_me", "", time() - 3600, "/", "", true, true);

// kill session
session_destroy();

header("Location: login.php");
exit;
?>
