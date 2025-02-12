<?php
session_start();
require_once 'database.php';

// sjekker om brukeren er kul og authenticated, vel, alle som bruker ord på nett er kul så den sjekker egentlig bare om du er authenticated
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}

// henter alle dokumenter som tilhører brukeren sortert etter sist endret/redigert
$stmt = $mysqli->prepare("SELECT id, title, last_modified FROM documents WHERE user_id = ? ORDER BY last_modified DESC"); // forbereder sql query, '?' er placeholder for verdien som blir nevnt neste linje
$stmt->bind_param("i", $_SESSION['user_id']); // binder faktiske verdier til placeholder plassen skrevet med '?' forrige linje, "i" betyr at verdien er en integer.
$stmt->execute(); // utfører / executer sql queryen
$result = $stmt->get_result(); // henter resultatet fra queryen

// send tilbake listen over dokumenter som json
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
