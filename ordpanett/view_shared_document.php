<?php
require_once 'database.php';
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Ok... så du skal liksom se et delt dokument, men så sier du ikke hvilke dokument? 💔");
}

// finner dokumentet ved å se på share token :solbriller emotikon:
$stmt = $mysqli->prepare("SELECT d.title, d.content, d.last_modified, u.username, u.profile_picture FROM documents d JOIN users u ON d.user_id = u.id WHERE d.share_token = ?");

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$document = $result->fetch_assoc();

if (!$document) {
    die("Var ingen dokument der >:(.");
}

// link
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$full_url = $protocol . "://" . $host . $request_uri;
$profile_picture_url = $protocol . "://" . $host . "/ordpanett/uploads/" . $document['profile_picture'];
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
    <meta property="og:title" content="<?php echo htmlspecialchars($document['title']); ?>">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="Ord På Nett">
    <meta property="og:url" content="<?php echo $full_url; ?>">
    <meta property="og:image" content="<?php echo $profile_picture_url; ?>">
    <meta property="og:description" content="Dette dokumentet er delt ved deg via Ord På Nett. Dokumentet er skrivebeskyttet, som vil si at du ikke kan redigere noe. Du behøver ikke logge inn for å se dokumentet.">
</head>
<body>
    <div class="container" id="sharedContainer">
        <p id="read-only-status">Skrivebeskyttet (Read-only)</p>
        <h1 id="title">Ord På Nett | Delt dokument</h1>

        <div class="options" id="shared-options">
            <h2>Dokumentinfo:</h2>
            <p><b>Navn:</b> <?php echo htmlspecialchars($document['title']);?></p>
            <p><b>Eid av: </b> <?php echo htmlspecialchars($document['username']);?></p>
            <p><b>Sist endret:</b> <span id="last-modified-display"><?php echo htmlspecialchars($document['last_modified']);?></span></p>
        </div>

        <div class="text-input" id="shared-text-input" contenteditable="false">
            <?php echo $document['content']; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log("poller for oppdateringer hvert 10. sekund")
        const sharedTextInput = document.getElementById('shared-text-input');
        const lastModifiedDisplay = document.getElementById('last-modified-display');

        let currentTimestamp = '<?php echo $document['last_modified']; ?>';
        const token = '<?php echo $token; ?>';

        if (!token) {
            console.error('du har ikke noe token lil bro');
            return;
        }

        // poll
        setInterval(() => {
            const url = `/ordpanett/scripts/check_for_updates.php?token=${encodeURIComponent(token)}&timestamp=${encodeURIComponent(currentTimestamp)}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`http error >:( status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'updated') {
                        console.log('dokument er oppdatert, fetcher content');
                        sharedTextInput.innerHTML = data.content;
                        lastModifiedDisplay.textContent = data.last_modified;
                        currentTimestamp = data.last_modified;
                    }
                })
                .catch(error => {
                    console.error('tror det oppstod en liten feil her :( ', error);
                });
        }, 5000);
    });
    </script>
</body>
</html>
