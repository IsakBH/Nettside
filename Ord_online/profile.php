<?php
session_start();
require_once 'database.php';

// sjekker om brukeren er logget inn, hvis ikke, redirect til innloggings siden
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// oppdatering av  brukernavn
if (isset($_POST['new_username'])) {
    $new_username = $mysqli->real_escape_string($_POST['new_username']);

    // sjekker om brukernavnet allerede finnes i databasen (om det er brukt av en annen bruker)
    $check_sql = "SELECT id FROM users WHERE username = ? AND id != ?";
    $check_stmt = $mysqli->prepare($check_sql);
    $check_stmt->bind_param("si", $new_username, $_SESSION['user_id']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Brukernavnet er allerede i bruk. Prøv et annet.";
    } else {
        // oppdater brukernavnet i databasen
        $sql = "UPDATE users SET username = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $new_username, $_SESSION['user_id']);

        if ($stmt->execute()) {
            $_SESSION['username'] = $new_username;
            $success = "Brukernavn oppdatert.";
        } else {
            $error = "Kunne ikke oppdatere brukernavn :(";
        }
    }
}

// sletting av bruker
if (isset($_POST['delete_account'])) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);

    if ($stmt->execute()) {
        session_destroy();
        header('Location: login.php');
        exit();
    } else {
        $error = "Kunne ikke slette konto";
    }
}

// oppdatering av profilbilde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif']; // filtypene bruker for lov til å laste opp
        $filename = $_FILES['new_profile_picture']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // lag random filnavn og last bildet opp til uploads
            $new_filename = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], 'uploads/' . $new_filename);

            // oppdater profilbilde i databasen
            $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $new_filename, $_SESSION['user_id']);

            if ($stmt->execute()) {
                $_SESSION['profile_picture'] = $new_filename;
                $success = "Oppdatering av profilbilde vellykket";
            } else {
                $error = "Oppdatering av profilbilde mislykket";
            }
        }
    }
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
