<?php
session_start();
require_once '../database.php';

// håndterer innlogging
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);

    // sjekker brukernavn og passord opp mot databasen
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // verifiser brukernavn og passord og lager session hvis de er riktig
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_picture'] = $user['profile_picture'];

        /*
        // remember me funksjonalitet
        if (isset($_POST['remember_me'])) {
            $token = bin2hex(random_bytes(32)); // genererer en random token
            $expires = date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60)); // varer i 30 dager :-)

            error_log("Ny husk meg token: " . $token); // skriver ut den nye tokenen til error loggen

            // hvis brukeren har flere sessions, slett de
            $delete_sql = "DELETE FROM sessions WHERE user_id = ?";
            $delete_stmt = $mysqli->prepare($delete_sql);
            $delete_stmt->bind_param("i", $user['id']);
            $delete_stmt->execute();

            // lagre ny token
            $sql = "INSERT INTO sessions (user_id, token, expires_at) VALUES (?, ?, ?)"; // skriver inn tokenen i databasen - id-en til brukeren som eier tokenen, selve tokenen og når den utløper
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $user['id'], $token, $expires); // binder paramaters med user id, token og når den utløper | det er "iss" fordi verdiene er int - string - string

            // setter en cookie med tokenen
            if ($stmt->execute()) {
                setcookie( // sett en kul cookie med secure og httponly flags
                    "remember_me",
                    $token,
                    time() + (30 * 24 * 60 * 60), // 30 dager
                    "/", // path
                    "", // domain
                    true, // secure -> cookien blir bare overført via sikre kanaler, altså HTTPS
                    true // httponly -> betyr at bare serveren kan se den
                );
                error_log("Setting av ny husk meg token vellykket"); // skriver ut til error loggen
            } else {
                error_log("Kunne ikke lagre husk meg token -_-: " . $stmt->error); // skriver ut til error loggen
            }
        }
        */

        header('Location: ../index.php'); // redirecter til hovedsiden
        exit();
    } else {
        $error = "Ugyldig brukernavn eller passord"; // error melding hvis du skrev ugyldig brukernavn eller passord
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ord På Nett | Logg inn</title>
    <link rel="stylesheet" href="../styling/texteditor.css">
    <script src="../scripts/texteditor.js"></script>
    <script src="../scripts/applydarkmode.js"></script>
    <script src="../scripts/applygreenmode.js"></script>
    <link rel="icon" href="../assets/ordlogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Open Graph meta-tagger -->
    <meta property="og:title" content="Ord På Nett">
    <meta property="og:description" content="Nå med en changelog side! Ord på Nett er et kraftig og brukervennlig tekstbehandlingsverktøy utviklet av meg (Isak Brun Henriksen). Med fokus på ytelse, enkelhet og tilgjengelighet, er Ord på Nett et ideelt valg for studenter, forfattere, forskere, profesjonelle, og egentlig alle yrker i hele verden som trenger et pålitelig og fleksibelt skriveverktøy.">
    <meta property="og:image" content="https://isak.brunhenriksen.no/ordpanett/assets/ordlogo.png">
    <meta property="og:url" content="https://isak.brunhenriksen.no/ordpanett">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="no_NO">
    <meta property="og:site_name" content="Ord På Nett">
</head>

<body>
    <div class="auth-container">
        <h2>Logg inn</h2>
        <p>
            For å bruke Ord på Nett, må du logge inn.
        </p> <br>

        <?php if (isset($error)): ?> <!-- hvis det oppstod en feil-->
            <div class="error"><?php echo $error; ?></div> <!-- for error melding -->
        <?php endif; ?> <!-- exiter if statement -->

        <form method="POST">

            <div class="form-group">
                <label>Brukernavn:</label>
                <input type="text" name="username" placeholder="brukernavn" required>
            </div>

            <div class="form-group">
                <label>Passord:</label>
                <input type="password" name="password" placeholder="passord" required>
            </div>

            <label for="remember_me">
                <input type="checkbox" id="remember_me" name="remember_me"> Husk meg
            </label> <br> <br>

            <button id="submit" type="submit">Logg inn</button>

        </form>

        <p>Har du ikke bruker enda? <a href="register.php">Registrer deg her</a></p>
    </div>
</body>

</html>