<?php
session_start();
require_once 'database.php';

// Hvis brukeren allerede er logget inn via session, gjør ingenting
if (isset($_SESSION['user_id'])) {
    return;
}

// Hvis en "Husk meg"-cookie eksisterer, sjekk om den er gyldig
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // Sjekk om token finnes i sessions-tabellen og er gyldig
    $sql = "SELECT user_id FROM sessions WHERE token = ? AND expires_at > NOW()";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Logg inn brukeren automatisk
        $_SESSION['user_id'] = $user['user_id'];

        // Hent også brukernavn og profilbilde
        $sql = "SELECT username, profile_picture FROM users WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $user['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $userdata = $result->fetch_assoc();

        $_SESSION['username'] = $userdata['username'];
        $_SESSION['profile_picture'] = $userdata['profile_picture'];
    } else {
        // Ugyldig token – slett cookie
        setcookie("remember_me", "", time() - 3600, "/", "", true, true);
    }
}
?>
