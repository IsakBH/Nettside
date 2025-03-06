<?php
session_start();
require_once 'database.php';

// hvis brukeren allerede er logget inn via session så gjør ingenting
if (isset($_SESSION['user_id'])) {
    return;
}

// hvis en remember me cookie finnes, sjekk om den er gyldig
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // debugging
    error_log("Checking remember_me token: " . $token);

    // sjekker om token/id finnes i databasen og er gyldig
    $sql = "SELECT user_id FROM sessions WHERE token = ? AND expires_at > NOW()";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        error_log("Valid token found for user_id: " . $user['user_id']);
        // logg brukeren inn automatisk
        $_SESSION['user_id'] = $user['user_id'];

        // hent brukernavn og profilbilde
        $sql = "SELECT username, profile_picture FROM users WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $user['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $userdata = $result->fetch_assoc();

        $_SESSION['username'] = $userdata['username'];
        $_SESSION['profile_picture'] = $userdata['profile_picture'];
    } else {
        error_log("No valid token found");
        // ugyldig eller utløpt token - slett cookie
        setcookie("remember_me", "", time() - 3600, "/", "", true, true);
    }
}
