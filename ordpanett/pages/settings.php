<?php
session_start();
require_once '../database.php';

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
            move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], '../uploads/' . $new_filename);

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
    <title>Ord På Nett | Instillinger</title>
    <link rel="stylesheet" href="../styling/texteditor.css">
    <script src="../scripts/texteditor.js"></script>
    <script src="../scripts/applydarkmode.js"></script>
    <link rel="icon" href="../assets/ordlogo.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <div class="profile-settings">
        <h2>Ord på Nett instillinger</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="current-profile">
            <img src="../uploads/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profilbilde">
        </div>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Endre profilbilde:</label>
                <input type="file" name="new_profile_picture">
            </div>

            <div class="form-group">
                <label>Endre brukernavn:</label>
                <input type="text" name="new_username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
            </div>

            <!-- Rounded switch -->
            <label class="switch">
                <input id="themeToggle" type="checkbox" onclick="toggleDarkMode()">
                <span class="slider round"></span>
            </label>
            <label>Dark mode</label>
            <br> <br>

            <button id="submit" type="submit">Oppdater instillinger</button>
        </form>

        <!-- slett bruker -->
        <form method="POST" class="delete-account-form" onsubmit="return confirm('Skummelt!!!!!! \nEr du sikker på at du vil slette kontoen din? Dette kan ikke angres.');">
            <input type="hidden" name="delete_account" value="1">
            <button id="delete-account" type="submit">Slett bruker (med bekreftelse)</button>
        </form>
        <a id="logout" href="logout.php">Logg ut</a>
        <br>

        <a id="backButton" href="../index.php">Tilbake til Ord på Nett</a>
    </div>
</body>

</html>
