<?php
session_start();
require_once "../database.php";

// sjekker om brukeren er logget inn, hvis ikke, redirect til innloggings siden
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ord På Nett | Din profil</title>
    <link rel="stylesheet" href="../styling/texteditor.css">
    <script src="../scripts/texteditor.js"></script>
    <link rel="icon" href="../assets/ordlogo.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <div class="profile-settings">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?>s profil</h2>
        <div class="current-profile">
            <img src="../uploads/<?php echo htmlspecialchars(
                $_SESSION["profile_picture"]
            ); ?>" alt="Profilbilde">
        </div>
        <a id="backButton" href="../index.php">Tilbake til Ord på Nett</a>
    </div>
</body>

</html>
