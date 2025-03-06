<?php
session_start();
require_once 'database.php';

// Håndterer innlogging
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);

    // Sjekker brukernavn og passord mot databasen
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifiser passord og opprett session hvis riktig
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_picture'] = $user['profile_picture'];

        // Husk meg-funksjonalitet (setter en cookie)
        if (isset($_POST['remember_me'])) {
            // Generer et sikkert tilfeldig token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60)); // 30 dager

            // Lagre tokenet i sessions-tabellen
            $sql = "INSERT INTO sessions (user_id, token, expires_at) VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE token=?, expires_at=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("issss", $user['id'], $token, $expires, $token, $expires);
            $stmt->execute();

            // Sett en sikker cookie for husk-meg
            setcookie("remember_me", $token, time() + (30 * 24 * 60 * 60), "/", "", true, true);
        }

        header('Location: index.php');
        exit();
    } else {
        $error = "Ugyldig brukernavn eller passord";
    }
}
?>

?>

<!DOCTYPE html>
<html>
<head>
    <title>Logg inn</title>
    <link rel="stylesheet" href="texteditor.css">
    <script src="texteditor.js"></script>
    <link rel="icon" href="../Pictures/ordlogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
    <div class="auth-container">
        <h2>Logg inn</h2>
        <p>
        For å bruke Ord på Nett, må du logge inn.
        </p> <br>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Brukernavn:</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Passord:</label>
                <input type="password" name="password" required>
            </div>

            <button id="submit" type="submit">Logg inn</button>

        </form>

        <p>Har du ikke bruker enda? <a href="register.php">Registrer deg her</a></p>
    </div>
</body>
</html>
