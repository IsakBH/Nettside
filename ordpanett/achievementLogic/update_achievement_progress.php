<?php
session_start();
header('Content-Type: application/json');
require 'db_connection.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'error' => 'Bruker ikke logget inn']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$event = $data['event'] ?? null;
$value = $data['value'] ?? 0;

if (!$event) {
    echo json_encode(['success' => false, 'error' => 'Manglende event']);
    exit;
}

$achievementUnlocked = null;

// 1. Finn alle achievements som matcher event
$stmt = $conn->prepare("SELECT id, name, description, icon_url, trigger_value FROM achievements WHERE trigger_event = ?");
$stmt->bind_param("s", $event);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $achievementId = $row['id'];
    $triggerValue = $row['trigger_value'];

    // 2. Hent nåværende progresjon
    $progressStmt = $conn->prepare("SELECT progress_value FROM achievement_progress WHERE user_id = ? AND achievement_id = ?");
    $progressStmt->bind_param("ii", $userId, $achievementId);
    $progressStmt->execute();
    $progressRes = $progressStmt->get_result();
    
    $current = 0;
    if ($progressRes->num_rows > 0) {
        $current = (int) $progressRes->fetch_assoc()['progress_value'];
    }

    // 3. Oppdater progresjon
    $newProgress = $current + $value;
    $now = date('Y-m-d H:i:s');
    
    $conn->query("INSERT INTO achievement_progress (user_id, achievement_id, progress_value, last_updated)
                  VALUES ($userId, $achievementId, $newProgress, '$now')
                  ON DUPLICATE KEY UPDATE progress_value = $newProgress, last_updated = '$now'");

    if ($newProgress >= $triggerValue) {
        $insertResult = $conn->query("INSERT IGNORE INTO user_achievements (user_id, achievement_id, achieved_at) VALUES ($userId, $achievementId, '$now')");
            $achievementUnlocked = [
                'title' => $row['name'],
                'message' => $row['description'],
                'icon_url' => $row['icon_url']
            ];
    }
}


echo json_encode([
    'success' => true,
    'achievement_unlocked' => $achievementUnlocked
]);
