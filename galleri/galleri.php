<!doctype html>
<html lang="no">

<head>
    <title> Isak B. Henriksen </title>
    <link rel="icon" href="/Pictures/Tux.svg.png">
    <link rel="stylesheet" href="../Stylesheets/styling.css">
    <script src="../Javascript/toggle.js"></script>
    <meta charset="utf-8">
</head>

<body>

    <!--- Navigasjonsbar -->
    <?php
    include("../Include/HTML/navbar.html");
    ?>

    <!---- Galleri -->
    <h1> Galleri </h1>

    <div id="gallery">
        <?php
        $db = new mysqli('localhost', 'isak', 'some_pass', 'mydb');

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $result = $db->query("SELECT id, name, image_data FROM images");

        while ($row = $result->fetch_assoc()) {
            $image_data = base64_encode($row['image_data']);
            echo "<img id='galleribilde'
                               src='data:image/jpeg;base64,{$image_data}'
                               alt='{$row['name']}'
                               title='{$row['name']}'>";
        }

        $db->close();
        ?>
    </div>

    <!--- Ionic icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons
