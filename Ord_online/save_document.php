<?php
session_start();
require_once 'database.php';

// debug logging
error_log("save_document.php called");
error_log("Session user_id: " . $_SESSION['user_id']);
error_log("POST data: " . file_get_contents('php://input'));

// sjekker om brukeren er kul og authenticated, vel, alle som bruker ord på nett er kul så den sjekker egentlig bare om du er authenticated
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}

// ajax :))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))) det er kult
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];

// håndterer ulike handlinger, lage nytt dokument og oppdater dokument
if ($data['action'] === 'create') {
    // opprett nytt dokument
    $stmt = $mysqli->prepare("INSERT INTO documents (user_id, title, content) VALUES (?, ?, ?)"); // forbereder sql query, '?' er en placeholder verdi
    $content = '';
    $stmt->bind_param("iss", $user_id, $data['title'], $content);
    $success = $stmt->execute();
    echo json_encode(['success' => $success, 'documentId' => $mysqli->insert_id]);
}
elseif ($data['action'] === 'update') {
    // oppdater allerede eksisterende dokument
    $stmt = $mysqli->prepare("UPDATE documents SET content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $data['content'], $data['id'], $user_id);
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
}
