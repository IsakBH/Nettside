<?php
require_once 'database.php';
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Ok... så du skal liksom se et delt dokument, men så sier du ikke hvilke dokument? 💔");
}

// finner dokumentet ved å se på share token :solbriller emotikon:
$stmt = $mysqli->prepare("SELECT d.title, d.content, d.last_modified, u.username FROM documents d JOIN users u ON d.user_id = u.id WHERE d.share_token = ?");

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$document = $result->fetch_assoc();

if (!$document) {
    die("Var ingen dokument der >:(.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ord På Nett | Delt dokument: <?php echo htmlspecialchars($document['title']); ?></title>
    <link rel="stylesheet" href="styling/texteditor.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="./scripts/texteditor.js"></script>
    <script src="./scripts/applydarkmode.js"></script>
    <script src="./scripts/applyfloatmode.js"></script>
    <script src="./scripts/applygreenmode.js"></script>
    <link rel="icon" href="./assets/ordlogo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="container" id="sharedContainer">
        <p id="read-only-status">Skrivebeskyttet (Read-only)</p>
        <h1 id="title">Ord På Nett | Delt dokument</h1>

        <div class="options" id="shared-options">
            <h2>Dokumentinfo:</h2>
            <p><b>Navn:</b> <?php echo htmlspecialchars($document['title']);?></p>
            <p><b>Eid av: </b> <?php echo htmlspecialchars($document['username']);?></p>
            <p><b>Sist endret:</b> <?php echo htmlspecialchars($document['last_modified']);?></p>
        </div>

        <div class="text-input" id="shared-text-input" contenteditable="false">
            <?php echo $document['content']; ?>
        </div>
    </div>
</body>
</html>
