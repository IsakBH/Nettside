<?php
session_start();
require_once 'database.php';

// Slett session fra databasen hvis eksisterer
if (isset($_SESSION['user_id'])) {
    $sql = "DELETE FROM sessions WHERE user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

// Ødelegg session og slett cookie
session_destroy();
setcookie("remember_me", "", time() - 3600, "/", "", true, true);

header("Location: index.php");
exit;
?>
