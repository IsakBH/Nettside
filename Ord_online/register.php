<?php
session_start();
require_once 'database.php';

// håndter registrering
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // opplasting av profilbilder
    $profile_picture = 'default.png';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif']; // de tillatte filtypene jeg har |||||||| TODO: LEGG TIL EN MELDING SOM SIER HVILKE FILTYPER DEN AKSEPTERER HVIS UPLOADEN FEILER
        $filename = $_FILES['profile_picture']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // valider og last opp bildet
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/' . $new_filename);
            $profile_picture = $new_filename;
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/' . $new_filename)) {
                error_log('Failed to move uploaded file. Error: ' . error_get_last()['message']);
                $error = "Kunne ikke laste opp bildet. Sjekk tillatelser.";
            }
        }
    }

    // registrer ny bruker i databasen
    $sql = "INSERT INTO users (username, password, profile_picture) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $profile_picture);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Username already exists";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrer</title>
    <link rel="stylesheet" href="texteditor.css">
    <script src="texteditor.js"></script>
    <link rel="icon" href="../Pictures/ordlogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
    <div class="auth-container">
        <h2>Registrer deg</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Brukernavn:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Passord:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Profilbilde:</label>
                <input type="file" name="profile_picture">
            </div>
            <button id="submit" type="submit">Registrer</button>
        </form>
        <p>Har du allerede bruker? <a href="login.php">Logg inn her</a></p>
    </div>
</body>
</html>
