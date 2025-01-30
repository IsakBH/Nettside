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
let olButton = document.getElementById("insertOrderedList");
let ulButton = document.getElementById("insertUnorderedList");
let fontList = [
    "Arial",
    "Times New Roman",
    "Cursive",
    "UnifrakturMaguntia",
    "Fantasy",
    "Courier New",
    "Impact",
];
let seenEasterEgg = false;

function sjekkFilNavn(filename) {
    return filename.toLowerCase().endsWith(".txt");
}

// lagre tekst som fil
function saveTextAsFile() {
    // gjør turndownService klar til bruk og sånn (hvordan skal jeg forklare dette på en bedre måte?????????)
    const turndownService = new TurndownService();

    // hent html dataen brukeren har skrevet inn i tekst boksen
    const htmlContent = document.getElementById("text-input").innerHTML;
    const markdownContent = turndownService.turndown(htmlContent);

    let filename = prompt("Skriv inn navn på dokumentet", "ord.md");

    // sjekker hvis filnavnet slutter med .md (akkurat det samme som det jeg hadde før med .txt, men bare med .md)
    if (!filename.toLowerCase().endsWith(".md")) {
        filename = filename + ".md";
        console.log("Filnavnet hadde ikke .md, og det har nå blitt lagt til.");
    }

    const blob = new Blob([markdownContent], { type: "text/markdown" });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");

    a.href = url;
    a.download = filename;
    a.click();

    window.URL.revokeObjectURL(url);
}

function loadTextFile() {
    const input = document.createElement("input");
    input.type = "file";
    input.accept = ".md";

    input.onchange = function (e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function () {
            const markdownContent = reader.result;
            // konverter markdown til html
            const htmlContent = marked.parse(markdownContent);
            document.getElementById("text-input").innerHTML = htmlContent;
        };

        reader.readAsText(file);
    };

    input.click();
}

// funksjon for å lagre innholdet (tekst bufferet) til localstorage
const saveContent = () => {
    try {
        const content = writingArea.innerHTML; // lager en variabel som lagrer innholdet (tekst bufferet)
        localStorage.setItem("textEditorContent", content); // lager et localstorage item greie ting med content variabelen
        console.log("Innhold lagret"); // bekrefter at innholdet ble lagret
    } catch (error) {
        // hvis error
        console.error("Feil ved lagring av innhold:", error); // sier ifra at det skjedde en feil
    }
};

// funksjon for å laste inn innhold fra localstorage
const loadContent = () => {
    try {
        const savedContent = localStorage.getItem("textEditorContent");
        if (savedContent) {
            writingArea.innerHTML = savedContent;
            console.log("Innhold lastet");
        }
    } catch (error) {
        console.error("Feil ved lasting av innhold:", error);
    }
};

// funksjon som initialiserer Ord Online
const initializer = () => {
    highlighter(alignButtons, true);
    highlighter(spacingButtons, true);
    highlighter(formatButtons, false);
    highlighter(scriptButtons, true);

    fontList.map((value) => {
        let option = document.createElement("option");
        option.value = value;
        option.innerHTML = value;
        fontName.appendChild(option);
    });

    for (let i = 1; i <= 7; i++) {
        let option = document.createElement("option");
        option.value = i;
        option.innerHTML = i;
        fontSizeRef.appendChild(option);
    }

    fontSizeRef.value = 3;

    // caller på loadContent funksjonen som laster inn innholdet fra localstorage
    loadContent();

    // legg til eventlisteners som alltid sikrer at innholdet er lagret til localstorage
    writingArea.addEventListener("input", debounce(saveContent, 500)); // lagrer innhold hver gang bruker skriver noe med 500 ms delay via debounce funksjonen
    writingArea.addEventListener("blur", saveContent); // lagrer når vinduet mister fokus
    window.addEventListener("beforeunload", saveContent); // lagrer når vinduet blir unloadet (blir lukket / går i sovemodus)
};

// gjør sånn at det er litt delay mellom lagring
function debounce(func, wait) {
    let timeout; // timer

    // lager/returnerer en ny funksjon som basically wrapper den gamle funksjonen med timer (hvordan skal jeg forklare dette bedre??????????)
    return function executedFunction(...args) {
        // args er alle argumenter som sendes til funksjonen
        const later = () => {
            clearTimeout(timeout); // fjerner gammel timeout
            func(...args); // kjører den funksjonen brukeren faktisk prøvde å kjøre
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait); // lager ny timer
    };
}

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
    if (/http/i.test(userLink)) {
        // hvis linken har http, bruk den
        modifyText(linkButton.id, false, userLink);
    } else {
        // hvis den ikke har http, legg det til og så bruk den
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
                if (!alreadyActive) {
                    // highlight knappen brukeren trykket på
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

// funksjonalitet for å legge til tabeller
document.getElementById("insertTable").addEventListener("click", () => {
    const rows = prompt("Enter number of rows:", "2");
    const cols = prompt("Enter number of columns:", "2");

    if (rows && cols) {
        // lag tabell container div
        const tableContainer = document.createElement("div");
        tableContainer.className = "table-container";

        // lag slett knapp
        const deleteButton = document.createElement("button");
        deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
        deleteButton.className = "table-delete-btn";
        deleteButton.title = "Delete Table";
        deleteButton.onclick = function () {
            if (confirm("Are you sure you want to delete this table?")) {
                tableContainer.remove();
            }
        };

        const table = document.createElement("table");
        table.style.width = "100%";
        table.style.borderCollapse = "collapse";
        table.style.marginBottom = "10px";

        // lag rader og celler
        for (let i = 0; i < rows; i++) {
            const row = table.insertRow();
            for (let j = 0; j < cols; j++) {
                const cell = row.insertCell();
                cell.contentEditable = true;
                cell.style.border = "1px solid #ccc";
                cell.style.padding = "8px";
                cell.style.minWidth = "50px";
                cell.innerHTML = "Cell";
            }
        }

        // legg til tabell og slett knapp til container
        tableContainer.appendChild(deleteButton);
        tableContainer.appendChild(table);

        // skriv inn tabeller på cursor position
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

// sletting av tabeller
document.addEventListener("contextmenu", function (e) {
    const tableElement = e.target.closest("table");
    if (tableElement) {
        e.preventDefault();
        if (confirm("Delete this table?")) {
            tableElement.closest(".table-container").remove();
        }
    }
});

////////////////// EASTER EGGS ////////////////////
writingArea.addEventListener("input", () => {
    saveContentToCookie();
    checkForGud();
    checkForMKX();
});

// sjekker om det står "gud" i tekst boksen der brukeren skriver
function checkForGud() {
    const content = writingArea.innerText.toLowerCase();
    const crossSymbol = document.getElementById("cross-symbol");

    if (content.includes("gud")) {
        crossSymbol.style.display = "block";
    } else {
        crossSymbol.style.display = "none";
    }
}

// sjekker om det står "mkx" i tekst boksen der brukeren skriver
function checkForMKX() {
    const content = writingArea.innerText.toLowerCase();

    if (content.includes("mkx")) {
        if (seenEasterEgg === false) {
            const music = new Audio("../Include/Musikk/mkx-10-20-30-40.mp3");
            music.play();
            seenEasterEgg = true;
        }
    }
}

// eksperimentering med tastatur snarveier
window.onkeydown = function (e) {
    if (e.ctrlKey) {
        // fet skrift
        if (e.key === "b") {
            e.preventDefault(); // stopper default action
            modifyText("bold", false, null);
        }
        // kursiv skrift
        else if (e.key === "i") {
            e.preventDefault(); // stopper default action
            modifyText("italic", false, null);
        }
        // understrek
        else if (e.key === "u") {
            e.preventDefault(); // stopper default action
            modifyText("underline", false, null);
        }
        // hyperlink
        else if (e.key === "k") {
            e.preventDefault(); // stopper default action
            linkButton.click(); // link knapp click
        }
        // lagre fil
        else if (e.key == "s") {
            e.preventDefault();
            saveTextAsFile();
        }
        // åpne fil
        else if (e.key == "o") {
            e.preventDefault();
            loadTextFile();
        }
        // strikethrough
        else if (e.key == "-") {
            e.preventDefault();
            modifyText("strikethrough", false, null);
        }
        // unordered list (uten tall)
        else if (e.key == "*") {
            e.preventDefault();
            ulButton.click();
        }
        // ordered list (med tall)
        else if (e.key == "/") {
            e.preventDefault();
            olButton.click();
        }
        // +1 skriftstørrelse
        if (e.key === ".") {
            e.preventDefault();
            let currentSize = parseInt(fontSizeRef.value);
            if (currentSize < 7) {
                fontSizeRef.value = currentSize + 1;
                modifyText("fontSize", false, currentSize + 1);
            }
        }

        // -1 skriftstørrelse
        if (e.key === ",") {
            e.preventDefault();
            let currentSize = parseInt(fontSizeRef.value);
            if (currentSize > 1) {
                fontSizeRef.value = currentSize - 1;
                modifyText("fontSize", false, currentSize - 1);
            }
        }
    }
};

window.onload = initializer();
