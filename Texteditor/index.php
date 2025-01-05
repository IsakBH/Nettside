<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ord Online V1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="texteditor.css" />
    <!-- ikoner fra font awesome og google fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  </head>
  <body>

    <!-- layouten av toolbaren er direkte kopiert fra Google Docs for "familiarity" -->

    <div class="container"> <!--  containeren for toolbaren -->
    <h1>Ord Online v1.4</h1>
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
            <i class="fa-solid fa-palette"></i> <style>#foreColor{color: #020929;} </style>
        </div>
        <div class="input-wrapper">
            <input type="color" id="backColor" class="adv-option-button" />
            <i class="fa-solid fa-paint-roller"></i> <style>#backColor{color: #020929;} </style>
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
      <div id="text-input" contenteditable="true"></div>
      <br>
      <a href="https://www.github.com/isakbh/Ord-text-editor" id="reklame" target="_blank">Skaff deg Ord nå!</a>
    </div>

    <!-- javascript link-->
    <script src="texteditor.js"></script>
  </body>
</html>
