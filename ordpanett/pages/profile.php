<?php
session_start();
require_once "../database.php";

// sjekker om brukeren er logget inn, hvis ikke, redirect til innloggings siden
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// finner achievements
$sql = "select * from user_achievements where user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$achievements = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ord På Nett | Din profil</title>
    <link rel="stylesheet" href="../styling/texteditor.css">
    <script src="../scripts/texteditor.js"></script>
    <?php echo "<script>const user_id = " . json_encode($user_id) . ";</script>"; ?>
    <script src="../scripts/profilestyling.js"></script>
    <script src="../scripts/applydarkmode.js"></script>
    <script src="../scripts/applygreenmode.js"></script>
    <link rel="icon" href="../assets/ordlogo.png" />

    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
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

        <?php
        foreach ($achievements as $achievement) {
            echo $achievement . "<br>";
        }
        ?>

        <a id="backButton" href="../index.php">Tilbake til Ord på Nett</a>
    </div>
</body>

</html>
