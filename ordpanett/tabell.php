<?php
session_start();
require_once 'database.php';

// sjekker om brukeren har en aktiv session, eller, er logget inn
if (!isset($_SESSION['user_id'])) {
    die("Du må være logget inn for å se denne siden.");
}

// selecter brukernavnene fra databasen
$sql = "SELECT username FROM users";
$result = $mysqli->query($sql);

// hvis det finnes brukere, lag en tabell
if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 50%; margin: 20px auto;'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='padding: 10px; text-align: left;'>kule ord på nett brukernavn</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // looper igjennom resultatet fra queryen og legger det inn i tabellen
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($row['username']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p style='text-align: center;'>Ingen brukere funnet.</p>";
}
?>
