<?php
/*Heisan isak, dette må du legge til i databasen din, sjekk at alt som linker til user table stemmer siden jeg ikke vet hvordan ditt usertable ser ut
CREATE TABLE achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    icon_url VARCHAR(255),
    trigger_event VARCHAR(100),
    trigger_value INT
);
CREATE TABLE user_achievements (
    user_id INT,
    achievement_id INT,
    achieved_at DATETIME,
    PRIMARY KEY (user_id, achievement_id)
);
CREATE TABLE achievement_progress (
    user_id INT,
    achievement_id INT,
    progress_value INT,
    last_updated DATETIME,
    PRIMARY KEY (user_id, achievement_id)
);*/

session_start();
header('Content-Type: application/json');
require 'db_connection.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'error' => 'Bruker ikke logget inn']);
    exit;
}

$sql = "
    SELECT a.id, a.name, a.description, a.icon_url,
           IF(ua.achievement_id IS NOT NULL, 1, 0) AS unlocked,
           ap.progress_value
    FROM achievements a
    LEFT JOIN user_achievements ua ON a.id = ua.achievement_id AND ua.user_id = ?
    LEFT JOIN achievement_progress ap ON a.id = ap.achievement_id AND ap.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $userId);
$stmt->execute();
$result = $stmt->get_result();

$achievements = [];
while ($row = $result->fetch_assoc()) {
    $achievements[] = $row;
}

echo json_encode([
    'success' => true,
    'achievements' => $achievements
]);

?>