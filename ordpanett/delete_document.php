<?php
session_start();
require_once 'database.php';

// sjekker om brukeren er kul og authenticated, vel, alle som bruker ord på nett er kul så den sjekker egentlig bare om du er authenticated
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}

// hent data fra ajax forespørsel (ajax er sigma alfa ulv)
$data = json_decode(file_get_contents('php://input'), true);

// forbereder og utfører sql query for å slette dokumentet
// verifiserer også at brukeren eier dokumentet via user_id session variabelen
$stmt = $mysqli->prepare("DELETE FROM documents WHERE id = ? AND user_id = ?"); // forbereder sql query, '?' er en placeholder for verdiene lagt til på linjen under
$stmt->bind_param("ii", $data['id'], $_SESSION['user_id']); // binder faktiske verdier til placeholder plassene skrevet med '?' i forrige linje. "ii" betyr at begge verdiene er integers.
$success = $stmt->execute(); // utfører / kjører sql queryen

// returnerer resultatet som JSON
echo json_encode(['success' => $success]);
