<?php
session_start();
require_once '../database.php';


if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Not authenticated']));
}
$userId = $_SESSION['user_id'];


$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['trigger_key'])) {
    die(json_encode(['success' => false, 'error' => 'du ga ingen trigger key :(']));
}
$received_key = $data['trigger_key'];


// finn achievement :solbriller emotikon:
$stmt = $mysqli->prepare("select id, name, description from achievements where trigger_key = ?");
$stmt->bind_param("s", $received_key);
$stmt->execute();
$result = $stmt->get_result();
$achievement = $result->fetch_assoc();
$stmt->close();


if (!$achievement) {
    die(json_encode(['success' => false, 'error' => 'den keyen der hadde ikke noe achievement, gitt! haha, gitt, sånn som git, lol']));
}
$achievementId = $achievement['id'];


// sjekker hvis brukeren allerede har achievementen
$stmt = $mysqli->prepare("SELECT id FROM user_achievements WHERE user_id = ? AND achievement_id = ?");
$stmt->bind_param("ii", $userId, $achievementId);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows > 0) {
    die(json_encode(['success' => false, 'message' => 'denne achievementen har du allerede']));
}


// gir achievement til brukeren
$stmt = $mysqli->prepare("INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, ?)");
$stmt->bind_param("ii", $userId, $achievementId);
$success = $stmt->execute();
$stmt->close();


// sender til frontenden :)))))
if ($success) {
    echo json_encode([
        'success' => true,
        'name' => $achievement['name'],
        'description' => $achievement['description']
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'kunne ikke sende achievement :(']);
}

?>