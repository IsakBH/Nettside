<?php
session_start();
require_once 'database.php';

// håndterer innlogging
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);

    // sjekker brukernavn og passord mot database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // verifiser passord og lag session om det er korrekt
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Ugyldig brukernavn eller passord";
    }
}
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
