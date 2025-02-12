<?php
session_start();
require_once 'database.php';

// Sjekk om bruker er logget inn
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}

// Hent data fra AJAX-forespørselen
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];

// Håndter ulike handlinger (create/update)
if ($data['action'] === 'create') {
    // Opprett nytt dokument
    $stmt = $mysqli->prepare("INSERT INTO documents (user_id, title, content) VALUES (?, ?, ?)");
    $content = '';
    $stmt->bind_param("iss", $user_id, $data['title'], $content);
    $success = $stmt->execute();
    echo json_encode(['success' => $success, 'documentId' => $mysqli->insert_id]);
}
elseif ($data['action'] === 'update') {
    // Oppdater eksisterende dokument
    $stmt = $mysqli->prepare("UPDATE documents SET content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $data['content'], $data['id'], $user_id);
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
}
