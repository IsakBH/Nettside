<?php
// variabel for versjonsnummer
$version = "v0.0.1";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Toner på Nett <?php echo $version; ?></title>

    <!-- meta tags for søkemotoroptimalisering -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- stylesheets -->
    <link rel="stylesheet" href="styling/main.css" />

    <!-- logoet til toner på nett som favicon -->
    <link rel="icon" href="assets/icons/logo.png" />

    <!-- ikoner fra font awesome og google fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <div class="song-manager">
        <div class="song-list">
            <h3>Mine sanger</h3>
            <button id="newSong" class="new-song-button">
                <i class="fa-solid fa-plus"></i>
                Ny sang
            </button>
            <div class="search-container">
                <i class="fa-solid fa-search"></i>
                <input type="text" id="songSearch" placeholder="Søk i sanger...">
            </div>
            <ul id="songsList"></ul>
        </div>
    </div>
</body>

</html>
