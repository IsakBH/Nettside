<?php
// variabel for versjonsnummer
$version = "v3.1.12"; // dropshadow på dokumentene i dokument listen
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ord På Nett <?php echo $version; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="texteditor.css" />
    <link rel="icon" href="../Pictures/ordlogo.png" />
    <!-- ikoner fra font awesome og google fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!-- Open Graph meta-tagger -->
    <meta property="og:title" content="Ord På Nett <?php echo $version; ?>">
    <meta property="og:description" content="Nå med funksjonalitet for flere dokumenter! \n Ord på Nett er et kraftig og brukervennlig tekstbehandlingsverktøy utviklet av meg (Isak Brun Henriksen). Med fokus på ytelse, enkelhet og tilgjengelighet, er Ord på Nett et ideelt valg for studenter, forfattere, forskere, profesjonelle, og egentlig alle yrker i hele verden som trenger et pålitelig og fleksibelt skriveverktøy.">
    <meta property="og:image" content="https://isak.brunhenriksen.no/Pictures/ordlogo.png">
    <meta property="og:url" content="https://isak.brunhenriksen.no/Ord_online">
    <meta property="og:type" content="website">
    <meta property="discord:app_id" content="1341008803189100676">

    <script src="https://unpkg.com/turndown/dist/turndown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>

<body>
    <?php
    session_start();
    require_once 'database.php';

    // redirect til login hvis ikke autentisert
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
    ?>

    <!-- layouten av toolbaren er direkte kopiert fra Google Docs for "familiarity" -->

    <button class="menu-toggle">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="document-manager">
        <div class="document-list">
            <h3>Mine dokumenter</h3>
            <button id="newDocument" class="new-doc-button">
                <i class="fa-solid fa-plus"></i>
                Nytt Ord dokument
            </button>
            <div class="search-container">
                <i class="fa-solid fa-search"></i>
                <input type="text" id="documentSearch" placeholder="Søk i dokumenter...">
            </div>
            <ul id="documentsList"></ul>
        </div>
    </div>

    <div class="container"> <!--  containeren for toolbaren -->
        <h1 id="header">Ord På Nett</h1>
        <p id="splashText"></p>
        <div class="options"> <!--  Toolbaren-->

            <!-- undo og redo -->
            <button id="undo" class="option-button" title="Angre (undo)">
                <i class="fa-solid fa-rotate-left"></i>
            </button>
            <button id="redo" class="option-button" title="Gjør om/angre angringen (redo)">
                <i class="fa-solid fa-rotate-right"></i>
            </button>

            <hr>

            <!-- overskrift / heading størrelse dropdown -->
            <select id="formatBlock" class="adv-option-button">
                <option value="H1" title="Overskrift 1 (heading 1)">Overskrift 1</option>
                <option value="H2" title="Overskrift 2 (heading 2)">Overskrift 2</option>
                <option value="H3" title="Overskrift 3 (heading 3)">Overskrift 3</option>
                <option value="H4" title="Overskrift 4 (heading 4)">Overskrift 4</option>
                <option value="H5" title="Overskrift 5 (heading 5)">Overskrift 5</option>
                <option value="H6" title="Overskrift 6 (heading 6)">Overskrift 6</option>
            </select>

            <hr>

            <!-- font knapper -->
            <select id="fontName" class="adv-option-button"></select>
            <select id="fontSize" class="adv-option-button"></select>

            <hr>

            <!-- tekst  formaterings greier -->
            <button id="bold" class="option-button format">
                <i class="fa-solid fa-bold"></i>
            </button>
            <button id="italic" class="option-button format">
                <i class="fa-solid fa-italic"></i>
            </button>
            <button id="underline" class="option-button format">
                <i class="fa-solid fa-underline"></i>
            </button>
            <button id="strikethrough" class="option-button format">
                <i class="fa-solid fa-strikethrough"></i>
            </button>

            <hr>

            <!-- farger -->
            <div class="input-wrapper">
                <input type="color" id="foreColor" class="adv-option-button" />
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="input-wrapper">
                <input type="color" id="backColor" class="adv-option-button" />
                <i class="fa-solid fa-paint-roller"></i>
            </div>

            <hr>

            <!-- hyper link -->
            <button id="createLink" class="adv-option-button">
                <i class="fa fa-link"></i>
            </button>
            <button id="unlink" class="option-button">
                <i class="fa fa-unlink"></i>
            </button>

            <!-- superscript knapper  -->
            <button id="superscript" class="option-button script">
                <i class="fa-solid fa-superscript"></i>
            </button>
            <button id="subscript" class="option-button script">
                <i class="fa-solid fa-subscript"></i>
            </button>

            <!-- liste knapper -->
            <button id="insertOrderedList" class="option-button">
                <div class="fa-solid fa-list-ol"></div>
            </button>
            <button id="insertUnorderedList" class="option-button">
                <i class="fa-solid fa-list"></i>
            </button>

            <!-- justify content knapper -->
            <hr>
            <button id="justifyLeft" class="option-button align">
                <i class="fa-solid fa-align-left"></i>
            </button>
            <button id="justifyCenter" class="option-button align">
                <i class="fa-solid fa-align-center"></i>
            </button>
            <button id="justifyRight" class="option-button align">
                <i class="fa-solid fa-align-right"></i>
            </button>

            <hr>
            <button id="insertTable" class="option-button" title="Insert Table">
                <i class="fa-solid fa-table"></i>
            </button>

            <!-- Add this where you want the save/load buttons to appear in your toolbar -->
            <hr>
            <button id="saveFile" class="option-button" title="Save as Text File">
                <i class="fa-solid fa-download"></i>
            </button>
            <button id="loadFile" class="option-button" title="Load Text File">
                <i class="fa-solid fa-upload"></i>
            </button>

            <button id="migrateFromLocal" class="option-button" title="Migrate from localStorage">
                <i class="fa-solid fa-file-import"></i> Migrer data
            </button>

            <!-- KNAPPER SOM IKKE FUNGERER (FIKS EN ELLER ANNEN GANG)
        <hr>
        <button id="indent" class="option-button spacing">
          <i class="fa-solid fa-indent"></i>
        </button>
        <button id="outdent" class="option-button spacing">
          <i class="fa-solid fa-outdent"></i>
        </button>
        -->
        </div>

        <!-- input boksen der du faktisk skriver teksten-->
        <div id="text-input">
            <p id="placeholder"></p>
        </div>

        <div id="counter">
            <span id="wordCount">0 ord</span>
            <span id="charCount">0 tegn</span>
        </div>

        <br>

        <div id="bottomtext">
            <a href="https://www.github.com/isakbh/Ord-text-editor" id="reklame" target="_blank">Skaff deg Ord nå! (kun på Linux)</a>
            <p id="version"><?php echo $version; ?></p>
        </div>

        <script src="https://giscus.app/client.js"
            data-repo="isakbh/nettside"
            data-repo-id="R_kgDOMnNuIw"
            data-category="Comments"
            data-category-id="DIC_kwDOMnNuI84Cme3r"
            data-mapping="url"
            data-strict="0"
            data-reactions-enabled="1"
            data-emit-metadata="0"
            data-input-position="bottom"
            data-theme="light"
            data-lang="en"
            crossorigin="anonymous"
            referrerpolicy="no-referrer-when-downgrade"
            async>
        </script>
    </div>

    <!-- menyen for konto instillinger og sånn -->
    <div class="profile-menu">
        <img src="uploads/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile" class="profile-picture">
        <div class="profile-dropdown">
            <div class="profile-info">
                <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
            <hr id="splitter">
            <a href="settings.php">Instillinger</a>
        </div>
    </div>

    <div id="cross-symbol"><i class="fa-solid fa-cross"></i></div>
    <p id="save-status"></p>

    <!-- javascript link-->
    <script src="texteditor.js"></script>
</body>

</html>
