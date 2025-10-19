<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}

$data = json_decode(file_get_contents('php://input'), true);
$document_id = $data['id'];

// henter dokument
$stmt = $mysqli->prepare("SELECT share_token FROM documents WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $document_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$doc = $result->fetch_assoc();

if ($doc) {
    $token = $doc['share_token'];

    // hvis det ikke er noe token så lag det
    if (empty($token)) {
        $token = bin2hex(random_bytes(16)); // lager kul 32 bokstav token :D
        $update_stmt = $mysqli->prepare("UPDATE documents SET share_token = ? WHERE id = ?");
        $update_stmt->bind_param("si", $token, $document_id);
        $update_stmt->execute();
    }
    // lager dele linken
    $share_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/ordpanett/view_shared_document.php?token=" . $token; // $_SERVER er så jævlig kult bro
    echo json_encode(['success' => true, 'link' => $share_link]);
} else {
    echo json_encode(['success' => false, 'error' => 'Document was not found or permission was denied. Bad boy!']);
}
?>