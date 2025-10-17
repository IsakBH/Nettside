<?php
session_start();
require_once 'database.php';

// sjekker om brukeren er kul og authenticated, vel, alle som bruker ord på nett er kul så den sjekker egentlig bare om du er authenticated
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}

// hent dokument id fra get
$id = $_GET['id'];

// hent dokumentet fra databasen, sjekk at brukeren eier dokumentet
$stmt = $mysqli->prepare("SELECT * FROM documents WHERE id = ? AND user_id = ?"); // forbereder sql query, '?' er placeholder for verdiene lagt til på linjen under
$stmt->bind_param("ii", $id, $_SESSION['user_id']); // binder faktiske verdier til placeholder plassene skrevet med '?' i forrige linje. "ii" betyr at begge
$stmt->execute(); // utfører / kjører sql queryen
$result = $stmt->get_result(); // henter resultatet fra queryen
$document = $result->fetch_assoc(); // konverter resultatet til en associative array som inneholder alle feltene fra dokumentet (id, content, user_id)

// send innholdet av dokumentet tilbake som JSON
echo json_encode([
    'success' => true,
    'content' => $document['content'],
    'name' => $document['title']
]);
