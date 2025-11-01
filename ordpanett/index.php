<?php
// variabel for versjonsnummer
$version = "v3.9.16"; // options er nå lik shared-options og knapper er mer uniform med resten av stylingen i vanlig light mode
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ord På Nett <?php if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') { echo "dev"; } else { echo $version; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="styling/texteditor.css" />
    <link rel="icon" href="assets/ordlogo.png" />

    <!-- ikoner fra font awesome og google fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!-- turndown og marked javascript biblioteker - for oversetting av html til markdown og motsatt -->
    <script src="https://unpkg.com/turndown/dist/turndown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>

<body>
    <?php
    session_start();
    require_once 'database.php';

    // redirect til login hvis ikke autentisert
    if (!isset($_SESSION['user_id'])) {
        header('Location: pages/login.php');
        exit();
    }
    $user_id = $_SESSION['user_id'];
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
        <!--<a id="changelogButton" title="Endringslogg Ord på Nett" href="pages/changelog.php">Endringslogg<i class="fa-solid fa-clock-rotate-left"></i></a>-->
    </div>

    <!--  containeren for toolbaren -->
    <div class="container">
        <h1 onclick="opnEasterEgg()" id="title">Ord På Nett <?php if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') { echo "dev"; } ?></h1>
        <div id="topRightContainer">
            <!-- menyen for konto instillinger og sånn -->
            <div class="profile-menu">
                <img src="uploads/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile" class="profile-picture">
                <div class="profile-dropdown">
                    <div class="profile-info">
                        <p><?php echo htmlspecialchars($_SESSION['username']) . " (" . htmlspecialchars($user_id) . ")"; ?></p>
                    </div>
                    <hr id="splitter">
                    <a href="pages/profile.php">Din profil</a>
                    <a href="pages/settings.php">Instillinger</a>

                    <?php

                    if($user_id === 1 || $user_id === 37) {
                        echo "<a id='admin-panel-button' href='pages/admin.php'>Admin panel</a>";
                    }

                    ?>

                    <a id="logoutIndex" href="pages/logout.php">Logg ut</a>
                    <!--<a href="">Prestasjoner? (på vei)</a>-->
                </div>
            </div>
        </div>

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
                <option value="H4" title="Vanlig skrift (normal text)">Vanlig tekst</option>
                <option value="H5" title="Undertittel 1 (subtitle 1)">Undertittel 1</option>
                <option value="H6" title="Undertittel 2 (subtitle 2)">Undertittel 2</option>
            </select>

            <hr>

            <!-- font knapper -->
            <select id="fontName" title="Ikke fungerende for øyeblikket" class="adv-option-button"></select>
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

            <hr>
            <button id="saveFile" class="option-button" title="Save as Text File">
                <i class="fa-solid fa-download"></i>
            </button>
            <button id="loadFile" class="option-button" title="Load Text File">
                <i class="fa-solid fa-upload"></i>
            </button>

            <!--
            <button id="migrateFromLocal" class="option-button" title="Migrate from localStorage">
                <i class="fa-solid fa-file-import"></i> Migrer data
            </button>
            -->
            <hr>
            <button id="calculator" class="option-button" title="Åpne kalkulator">
                <i class="fa-solid fa-calculator"></i>
            </button>

            <!-- kalkulator dropdown -->
            <div id="calculator-container" class="hidden">
                <input type="text" id="calc-display" disabled>
                <div class="buttons">

                    <button class="calc-btn" data-value="7">7</button>
                    <button class="calc-btn" data-value="8">8</button>
                    <button class="calc-btn" data-value="9">9</button>
                    <button class="calc-btn operator" data-value="/">÷</button>

                    <button class="calc-btn" data-value="4">4</button>
                    <button class="calc-btn" data-value="5">5</button>
                    <button class="calc-btn" data-value="6">6</button>
                    <button class="calc-btn operator" data-value="*">×</button>

                    <button class="calc-btn" data-value="1">1</button>
                    <button class="calc-btn" data-value="2">2</button>
                    <button class="calc-btn" data-value="3">3</button>
                    <button class="calc-btn operator" data-value="-">−</button>

                    <button class="calc-btn" data-value="0">0</button>
                    <button class="calc-btn" data-value=".">.</button>
                    <button class="calc-btn" id="clear">C</button>

                    <button class="calc-btn operator" data-value="+">+</button>
                    <button class="calc-btn equal" id="equals">=</button>
                </div>
            </div>

            <hr>
            <button id="print" class="option-button" title="Print ut dokumentet">
                <i class="fa-solid fa-print"></i>
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
        <div class="text-input" id="text-input">
            <p id="placeholder"></p>
        </div>

        <div id="bottomtext">
            <div> <!-- i en egen div slik at justify-content: space-between; ikke fucker med word- og charCount -->
                <span id="wordCount">0 ord</span>
                <span id="charCount">0 tegn</span>
            </div>
            <a id="version" href="pages/changelog.php"><?php echo $version; ?></a>
        </div>

        <br>

        <script src="https://giscus.app/client.js"
            data-repo="isakbh/nettside"
            data-repo-id="R_kgDOMnNuIw"
            data-category="Comments"
            data-category-id="DIC_kwDOMnNuI84Cme3r"
            data-mapping="url"
            data-strict="0"
            data-reactions-enabled="1"
            data-emit-metadata="0"
            data-input-position="top"
            data-theme="dark"
            data-lang="en"
            crossorigin="anonymous"
            referrerpolicy="no-referrer-when-downgrade"
            async>
        </script>
    </div>

    <p id="splashText" style="<?php echo isset($_SESSION['hide_splash_text']) && $_SESSION['hide_splash_text'] ? 'display: none;' : ''; ?>"></p> <!-- splash tekst-->

    <div id="cross-symbol"><i class="fa-solid fa-cross"></i></div>
    <p id="save-status"></p>

    <!-- javascript link-->
    <script src="scripts/texteditor.js"></script>
</body>

</html>
