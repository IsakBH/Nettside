<?php
session_start();
require_once 'database.php';

// sjekker om brukeren er logget inn, hvis ikke, redirect til innloggings siden
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Instillinger Ord på Nett</title>
    <link rel="stylesheet" href="texteditor.css">
    <script src="texteditor.js"></script>
    <script src="settings.js"></script>
    <link rel="icon" href="../Pictures/ordlogo.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <div class="profile-settings">
        <h2><?php echo htmlspecialchars($_SESSION['username']); ?>s profil</h2>

        <a id="backButton" href="index.php">Tilbake til Ord på Nett</a>
    </div>
</body>

</html>
