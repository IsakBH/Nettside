<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Heisan sveisan!</title>
    <link rel="stylesheet" type="text/css" href="texteditor.css">
</head>
<body>
    <div class="profile-settings">

        <h2>Hei, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <span id="bepatient">Brukere/profiler har enda ingen spesiell bruk, men det kommer snart. <br> <br> Snart vil du få tilgang til å lage flere forskjellige dokumenter som du kan bruke over flere enheter, så lenge du er innlogget. Men, hvorfor er det ingen bruk for brukere enda? Fordi jeg tenkte det er smart å først finne ut hvordan jeg gjør det før jeg gjør det. </span> <br>

        <br>

        <a id="iamready" href="index.php">Jeg er klar for å bruke Ord på Nett!</a>
    </div>
</body>
</html>
