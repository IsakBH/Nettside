<?php
session_start();
require_once 'database.php';

// sjekker om brukeren er kul og authenticated, vel, alle som bruker ord på nett er kul så den sjekker egentlig bare om du er authenticated
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Ikke autentisert']));
}

// ajax :))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))) det er kult
$data = json_decode(file_get_contents('php://input'), true); // bruker json for å decode dokumentet
$user_id = $_SESSION['user_id']; // gjør user id til session user id-en

// håndterer ulike handlinger, lage nytt dokument og oppdater dokument
if ($data['action'] === 'create') { // hvis brukeren gir action create
    // opprett nytt dokument
    $stmt = $mysqli->prepare("INSERT INTO documents (user_id, title, content) VALUES (?, ?, ?)"); // forbereder sql query
    $content = '';
    $stmt->bind_param("iss", $user_id, $data['title'], $content);
    $success = $stmt->execute();
    echo json_encode(['success' => $success, 'documentId' => $mysqli->insert_id]);
}

elseif ($data['action'] === 'update') { // hvis brukeren gir action update
    // oppdater/lagre endringer i allerede eksisterende dokument
    $stmt = $mysqli->prepare("UPDATE documents SET content = ? WHERE id = ? AND user_id = ?"); // lager sql query for å oppdatere dokumentet med ny content
    $stmt->bind_param("sii", $data['content'], $data['id'], $user_id); // binder paramaters med verdiene av data content (innholdet i dokumentet), data id (dokument id) og user id
    $success = $stmt->execute(); // kjører queryen
    echo json_encode(['success' => $success]);
}
