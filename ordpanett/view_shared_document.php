<?php
require_once 'database.php';
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Ok... så du skal liksom se et delt dokument, men så sier du ikke hvilke dokument? 💔");
}

// finner dokumentet ved å se på share token :solbriller emotikon:
$stmt = $mysqli->prepare("SELECT id, title, content FROM documents WHERE share_token = ?");
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

</head>
<body>
    <div class="container" id="sharedContainer">
        <h1 id="title">Ord På Nett | Delt dokument</h1>

        <div class="text-input" id="shared-text-input" contenteditable="false">
            <?php echo $document['content']; ?>
        </div>
    </div>
</body>
</html>
