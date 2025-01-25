// lager variabler av html verdier
let alignButtons = document.querySelectorAll(".align");
let spacingButtons = document.querySelectorAll(".spacing");
let formatButtons = document.querySelectorAll(".format");
let scriptButtons = document.querySelectorAll(".script");
let optionsButtons = document.querySelectorAll(".option-button");
let advancedOptionButton = document.querySelectorAll(".adv-option-button");
let fontName = document.getElementById("fontName");
let fontSizeRef = document.getElementById("fontSize");
let writingArea = document.getElementById("text-input");
let linkButton = document.getElementById("createLink");
let fontList = [
  "Arial",
  "Times New Roman",
  "Cursive",
];

// lagre tekst som fil
function saveTextAsFile() {
    const textContent = document.getElementById("text-input").innerHTML;
    // konverter HTML innhold til ren tekst
    const plainText = textContent.replace(/<[^>]*>/g, '\n');

    const blob = new Blob([plainText], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.href = url;
    a.download = 'ord-document.txt';
    a.click();

    window.URL.revokeObjectURL(url);
}

// last inn tekst fra fil
function loadTextFile() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.txt';

    input.onchange = function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const text = reader.result;
            document.getElementById("text-input").innerHTML = text;
        };

        reader.readAsText(file);
    };

    input.click();
}

// funksjon for å lagre innholdet til cookie
const saveContentToCookie = () => {
    const content = writingArea.innerHTML;
    document.cookie = `textEditorContent=${encodeURIComponent(content)}; expires=${new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString()}; path=/`;
};

// funksjon for å laste inn innholdet fra cookie
const loadContentFromCookie = () => {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'textEditorContent') {
            writingArea.innerHTML = decodeURIComponent(value);
            return;
        }
    }
};

const initializer = () => {
    highlighter(alignButtons, true);
    highlighter(spacingButtons, true);
    highlighter(formatButtons, false);
    highlighter(scriptButtons, true);

    // valg av fonts
    fontList.map((value) => {
        let option = document.createElement("option");
        option.value = value;
        option.innerHTML = value;
        fontName.appendChild(option);
    });

    // valg av fontstørrelse
    for (let i = 1; i <= 7; i++) {
        let option = document.createElement("option");
        option.value = i;
        option.innerHTML = i;
        fontSizeRef.appendChild(option);
    }

    fontSizeRef.value = 3;

    // last inn lagret innhold fra cookie
    loadContentFromCookie();

    // legg til en eventlistener for å lagre innholdet mens man skriver
    writingArea.addEventListener('input', () => {
        saveContentToCookie();
    });
};

// hoved logikken
const modifyText = (command, defaultUi, value) => {
  document.execCommand(command, defaultUi, value); // kjører kommandoene på teksten som er selected
  // basically, command er det den skal gjøre med teksten (f.eks bold, italic, etc), defaultUi er en sjekk for hvis nettleseren har en UI til det den skal gjøre, og value er info som fontSize = arial, fontSize = 3, bold = true, etc.
};

// basic operasjoner
optionsButtons.forEach((button) => {
  button.addEventListener("click", () => {
    modifyText(button.id, false, null);
  });
});

// valg som trenger options parameters, som for eksempel farger
advancedOptionButton.forEach((button) => {
  button.addEventListener("change", () => {
    modifyText(button.id, false, button.value);
  });
});

// link
linkButton.addEventListener("click", () => {
  let userLink = prompt("Enter a URL");
  if (/http/i.test(userLink)) { // hvis linken har http, bruk den
    modifyText(linkButton.id, false, userLink);
  } else { // hvis den ikke har http, legg det til og så bruk den
    userLink = "http://" + userLink;
    modifyText(linkButton.id, false, userLink);
  }
});

// highlight knapper når de er trykket inn (og vice versa)
const highlighter = (className, needsRemoval) => {
  className.forEach((button) => {
    button.addEventListener("click", () => {
      // needsRemoval = true betyr at bare en knapp skal være highlighted og andre skal være vanlig (ikke highlghted)
      if (needsRemoval) {
        let alreadyActive = false;

        // hvis knappen brukeren trykket på allerede er aktiv, deaktiver den
        if (button.classList.contains("active")) {
          alreadyActive = true;
        }

        // fjern highlight fra andre knapper
        highlighterRemover(className);
        if (!alreadyActive) { // highlight knappen brukeren trykket på
          button.classList.add("active");
        }
      } else {
        button.classList.toggle("active"); // toggler highlight
      }
    });
  });
};

const highlighterRemover = (className) => {
  className.forEach((button) => {
    button.classList.remove("active");
  });
};

// legg til event listeners til lagre og upload knapper
document.getElementById("saveFile").addEventListener("click", saveTextAsFile);
document.getElementById("loadFile").addEventListener("click", loadTextFile);

// Table insertion functionality
document.getElementById("insertTable").addEventListener("click", () => {
    const rows = prompt("Enter number of rows:", "2");
    const cols = prompt("Enter number of columns:", "2");

    if (rows && cols) {
        // Create table container div
        const tableContainer = document.createElement('div');
        tableContainer.className = 'table-container';

        // Create delete button
        const deleteButton = document.createElement('button');
        deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
        deleteButton.className = 'table-delete-btn';
        deleteButton.title = 'Delete Table';
        deleteButton.onclick = function() {
            if (confirm('Are you sure you want to delete this table?')) {
                tableContainer.remove();
            }
        };

        const table = document.createElement('table');
        table.style.width = '100%';
        table.style.borderCollapse = 'collapse';
        table.style.marginBottom = '10px';

        // Create rows and cells
        for (let i = 0; i < rows; i++) {
            const row = table.insertRow();
            for (let j = 0; j < cols; j++) {
                const cell = row.insertCell();
                cell.contentEditable = true;
                cell.style.border = '1px solid #ccc';
                cell.style.padding = '8px';
                cell.style.minWidth = '50px';
                cell.innerHTML = 'Cell';
            }
        }

        // Add table and delete button to container
        tableContainer.appendChild(deleteButton);
        tableContainer.appendChild(table);

        // Insert table container at cursor position or at the end
        const selection = window.getSelection();
        if (selection.getRangeAt && selection.rangeCount) {
            const range = selection.getRangeAt(0);
            range.deleteContents();
            range.insertNode(tableContainer);
        } else {
            writingArea.appendChild(tableContainer);
        }
    }
});

// Add this to your texteditor.js file
document.addEventListener('contextmenu', function(e) {
    const tableElement = e.target.closest('table');
    if (tableElement) {
        e.preventDefault();
        if (confirm('Delete this table?')) {
            tableElement.closest('.table-container').remove();
        }
    }
});

// eksperimentering med tastatur snarveier
window.onkeydown = function(e) {
    if (e.ctrlKey) { // sjekker etter ctrl og e
        if (e.key === 'b') { // ctrl + b for fet skrift
            e.preventDefault(); // stopper default action
            modifyText('bold', false, null);
        } else if (e.key === 'i') { // ctrl + i for kursiv skrift
            e.preventDefault(); // stopper default action
            modifyText('italic', false, null);
        } else if (e.key === 'u') { // ctrl + u for understrek
            e.preventDefault(); // stopper default action
            modifyText('underline', false, null);
        } else if (e.key === 'k') { // ctrl + k for hyprlink
            e.preventDefault(); // stopper default action
            linkButton.click(); // link knapp click
        }
    }
};

window.onload = initializer();
