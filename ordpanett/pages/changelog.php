<?php
session_start();
require_once '../database.php';

// redirect til login hvis ikke autentisert
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Endringslogg - Ord på Nett</title>
    <link rel="stylesheet" href="../styling/texteditor.css">
<script src="../scripts/applydarkmode.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="../assets/ordlogo.png" />
</head>
<body>
    <div id="changeLogTopBar">
        <h1 id="changeLogTitle">Endringslogg</h1>
        <a href="../index.php" id="changeLogBackButton">Tilbake til Ord på Nett</a>
    </div>
    <div id="changelog"></div>
    <script src="../scripts/changelog.js"></script>
    <script src="../scripts/applydarkmode.js"></script>
    <script src="../scripts/texteditor.js"></script>
</body>
</html>
