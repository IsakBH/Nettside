<!DOCTYPE html>
<html lang="no">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stein, Saks, Papir</title>
        <link rel="icon" href="../Pictures/isak.jpg"
        <link rel="stylesheet" href="/Stylesheets/styling.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        <!-- Open Graph meta-tagger -->
        <meta property="og:title" content="Stein Saks Papir">
        <meta property="og:description" content="Den beste online versjonen av Stein, Saks, Papir noensinne!!">
        <meta property="og:image" content="../Pictures/milliefin.jpg">
        <meta property="og:url" content="https://isak.brunhenriksen.no/SteinSaksPapir">
        <meta property="og:type" content="website">
    </head>

    <body>
        <?php
        include("../Include/HTML/navbar.html");
        ?>
        <div id="mainContent">
            <h1>Stein saks papir</h1>

            <div class="choices"> <!-- Stein saks papir knappene -->
                <button onclick="playGame('stein')"><i class="fa-solid fa-hand-back-fist"></i></button>
                <button onclick="playGame('saks')"><i class="fa-solid fa-scissors"></i></button>
                <button onclick="playGame('papir')"><i class="fa-solid fa-toilet-paper"></i></button>
            </div>

            <div id="playerDisplay">Du valgte: </div> <!-- Viser det du valgte (enten stein, saks eller papir) -->

            <div id="computerDisplay">Maskinen valgte: </div> <!-- Viser det maskinen valgte (enten stein, saks eller papir) -->

            <div class="scoreDisplay">Dine poeng:
                <span id="playerScoreDisplay">0</span>
            </div>
            <div class="scoreDisplay">Maskinens poeng:
                <span id="computerScoreDisplay">0</span>
            </div>
            <div id="resultDisplay"></div> <!-- Resultatet (hvem vant) -->
        </div>


        <div id="secondaryContent">
            <p><?php include("hvorfor.txt") ?></p>
        </div>

            <script src="main.js"></script>
    </body>
</html>
