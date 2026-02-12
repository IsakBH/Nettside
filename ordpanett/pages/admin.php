<?php
session_start();

// sjekker om brukeren er logget inn, hvis ikke, redirect til innloggings siden
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ord På Nett <?php if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') { echo "dev"; } else { echo "| Admin"; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="../styling/texteditor.css" />
    <link rel="icon" href="../assets/ordlogo.png" />

    <script src="../scripts/texteditor.js"></script>
    <script src="../scripts/applydarkmode.js"></script>
    <script src="../scripts/applygreenmode.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="admin-container">
        <div id="top-admin">
            <img src="/ordpanett/uploads/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile" class="profile-picture" id="admin-profile-picture">
            <p id="admin-username"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
    </div>
</body>

</html>
