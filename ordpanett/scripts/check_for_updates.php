<?php
require_once '../database.php';

$token = $_GET['token'] ?? '';
$client_timestamp = $_GET['timestamp'] ?? '';

if(empty($token) || empty($client_timestamp)) {
    http_response_code(400); // bad request >:(
    echo json_encode(['status' => 'error', 'message' => 'du mangler et par parametere lillebror']);
    exit;
}

$stmt = $mysqli->prepare("select content, last_modified from documents where share_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$document = $result->fetch_assoc();

if(!$document) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'det dokumentet finnes ikke bro']);
    exit;
}

if($document['last_modified'] > $client_timestamp) {
    echo json_encode([
        'status' => 'updated',
        'content' => $document['content'],
        'last_modified' => $document['last_modified']
    ]);
} else {
    echo json_encode(['status' => 'ingen endring siden sist poll']);
}

?>