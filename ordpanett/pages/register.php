<?php
session_start();
require_once '../database.php';

// håndter registrering
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // opplasting av profilbilder
    $profile_picture = 'default.png';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) { // hvis brukeren har lastet opp et profil bilde og det ikke oppstod en feil
        $allowed = ['jpg', 'jpeg', 'png', 'gif']; // de tillatte filtypene
        $filename = $_FILES['profile_picture']['name']; // henter filnavnet til uploaden
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // henter file extensionen (eller filutvidelsen hvis du virkelig vil ha det på norsk, da) til bildet

        // valider og last opp bildet
        if (in_array($ext, $allowed)) { // sjekker hvis file extensionen til bildet brukeren lastet opp er i $allowed arrayen
            $new_filename = uniqid() . '.' . $ext; // genererer en unik id basert på det nåværende klokkeslettet (tror jeg, i hvertfall) - for å ikke få conflicts med filnavn og sånt drit
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/' . $new_filename); // flytter den opplastede filen til uploads og gir den nytt filnavn (fra $new_filename variabelen)
            $profile_picture = $new_filename; // setter profilbildet
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/' . $new_filename)) { // hvis den ikke klarte å flytte bildet
                error_log('Kunne ikke flytte bildet :c. Error: ' . error_get_last()['message']); // skriver til error loggen at den ikke klarte å flytte bildet, og legger til error meldingen/feilmeldingen
                $error = "Kunne ikke laste opp bildet."; // setter error til kunne ikke laste opp bilde, slik at brukeren ser det
            }
        }
    }

    // registrer ny bruker i databasen
    $sql = "INSERT INTO users (username, password, profile_picture) VALUES (?, ?, ?)"; // query for å legge til bruker i databasen
    $stmt = $mysqli->prepare($sql); // forbereder sql queryen
    $stmt->bind_param("sss", $username, $password, $profile_picture); // binder paramaters til verdiene username, password og profile_picture

    if ($stmt->execute()) { // hvis den klarte å kjøre sql queryen
        header('Location: login.php'); // redirecter til login siden
        exit(); // exiter
    } else { // hvis den ikke klarte å kjøre sql queryen, eller, den klarte ikke lage ny bruker
        $error = "Kunne ikke lage bruker :("; // skriver at den ikke klarte å lage bruker til error meldingen
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ord På Nett | Registrer deg</title>
    <link rel="stylesheet" href="../styling/texteditor.css">
    <script src="../scripts/texteditor.js"></script>
    <link rel="icon" href="../assets/ordlogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>

<body>
    <div class="auth-container">
        <h2>Registrer deg</h2> <br>
        <?php if (isset($error)): ?> <!-- hvis det er en error-->
            <div class="error"><?php echo $error; ?></div> <!-- for error meldingen-->
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Brukernavn:</label>
                <input type="text" name="username" placeholder="brukernavn" required>
            </div>
            <div class="form-group">
                <label>Passord:</label>
                <input type="password" name="password" placeholder="passord" required>
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
