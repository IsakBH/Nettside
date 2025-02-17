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
const kulSplash = document.getElementById("splashText");
let seenEasterEgg = false;
// lager liste av fonter for font velge greien
let fontList = [
    "Arial",
    "Times New Roman",
    "Cursive",
    "UnifrakturMaguntia",
    "Fantasy",
    "Courier New",
    "Impact",
];
// lager liste over splash text som vises over Ord på nett tittelen.
let splashText = [
    "Jeg bruker ikke akebrett, fordi jeg har jo Ord på Nett",
    "Å danse ballett er nesten like fint som Ord på Nett",
    "Frisører liker ofte å flette, men jeg liker bare å bruke Ord på nettet",
    "Å se på et fint garnsett, er nesten som å skrive i Ord på nett",
    "Nå gikk jeg på et lite knett, men det gjør du aldri når du bruker Ord på nett",
    "Hun legen var godt annsett, nesten som Ord på nett",
    "Du blir sett på som ganske fett, om du bare bruker Ord på nett",
    "Jeg har alltid elsket en god forrett, men aldri like mye som Ord på nett",
    "Skjære brød på et skjærebrett? Nei, jeg har jo min kjære Ord på nett!",
    "Å bruke Ord på nett er ofte ganske lett",
    "Mange trodde soldatene til Napoleon brukte muskett, men jeg tror de brukte Ord på Nett.",
    "Kan aldri bruke et nettbrett igjen uten Ord på nett.",
    "Du vet aldri hvor du finner ditt neste favoritt fargepalett, men det gjør jeg. På Ord på nett.",
    "Ta portrett? Pfff, har jo Ord på nett.",
    "Jeg bruker aldri serviett, fordi jeg har jo Ord på nett!",
    "Når doen er tett, er det bare å finne fram Ord på Nett!",
    "Du blir kanskje ikke mett av å bruke Ord på Nett, men det er i hvertfall veldig lett.",
    "Har du vondt i hodet, ikke bruk tablett. Bruk Ord på Nett!",
    "Ord på Nett, like godt som en baguette!",
    "Hva brukte du for å skrive det? Bare gjett... det er jo Ord på Nett!",
    "Krokodillen som er på diett, bruker alltid Ord på Nett.",
    "Du trenger ikke stort budsjett for å bruke Ord på Nett.",
    "Avhengig av cigarett? Bruk Ord på Nett!",
    "Bruker du ikke Ord på Nett er det bare å gå i rettrett.",
    "Du må ha gått helt fra vettet om du ikke bruker Ord på Nettet",
];

// light/dark mode toggle
function toggleDarkMode() {
    const toggleButton = document.getElementById('themeToggle');
    document.body.classList.toggle('dark-theme');
    localStorage.setItem('darkMode', toggleButton.checked);
}

// sjekk og enable dark mode når siden lastes
function applyDarkMode() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-theme');
    }

    // hvis på settings siden, toggle switchen
    const toggleButton = document.getElementById('themeToggle');
    if (toggleButton) {
        toggleButton.checked = isDarkMode;
    }
}

// apply dark mode når siden lastes
document.addEventListener('DOMContentLoaded', applyDarkMode);

// funksjon for å telle antall bokstaver og tegn
function updateWordAndCharCount() {
    const text = writingArea.innerText || "";

    // antall tegn (med mellomrom)
    const charCount = text.length;

    // telle ord (splitter på mellomrom)
    const wordCount = text
        .trim()
        .split(/\s+/)
        .filter(word => word.length > 0)
        .length;

    // oppdaterer visningen under tekstboksen
    document.getElementById('wordCount').textContent = `${wordCount} ord`;
    document.getElementById('charCount').textContent = `${charCount} tegn`;
}

// eventlisteners som hører etter input for å oppdatere ord og bokstav telleren
writingArea.addEventListener('input', updateWordAndCharCount);
writingArea.addEventListener('paste', () => {
    setTimeout(updateWordAndCharCount, 0);
});

// bedre touch funksjonalitet
writingArea.addEventListener('touchstart', function(e) {
    const touch = e.touches[0];
    const selection = window.getSelection();
    const range = document.caretRangeFromPoint(touch.clientX, touch.clientY);
    if (range) {
        selection.removeAllRanges();
        selection.addRange(range);
    }
});

// hamburger meny
const menuToggle = document.querySelector('.menu-toggle');
const documentManager = document.querySelector('.document-manager');

menuToggle.addEventListener('click', () => {
    documentManager.classList.toggle('active');
});

// lukk menyen når man trykker utenfor
document.addEventListener('click', (e) => {
    if (!documentManager.contains(e.target) && !menuToggle.contains(e.target)) {
        documentManager.classList.remove('active');
    }
});

function migrateFromLocalStorage() {
    // sjekk om det finnes gammel data i localstorage
    const oldContent = localStorage.getItem('textEditorContent');

    if (oldContent) {
        // spør brukeren om han/hun vil migrere data
        if (confirm('BARE GJØR DETTE HVIS DU MANGLER DATA ETTER DEN FORRIGE OPPDATERINGEN! \nDETTE VIL OVERSKRIVE ALT DU HAR I DOKUMENTET DU HAR ÅPENT, LAG OG ÅPNE NYTT DOKUMENT FØR DU GJØR DETTE\n\nOrd har funnet gammel data i localStorage fra dokumentet du hadde før den store multi-dokument oppdateringen (v3.1), vil du migrere dataen til den nye versjonen? ')) {
            // plasser innholdet fra localstorage i textboksen
            writingArea.innerHTML = oldContent;

            // lagre innholdet i databasen :)
            saveDocument();

            // spør brukeren om å slette dataen fra localstorage
            if (confirm('Migrering fullført. Vil du slette det gamle innholdet fra localStorage?')) {
                localStorage.removeItem('textEditorContent');
            }

            showSaveStatus('Migrering fullført');
        }
    } else {
        alert('Ingen data funnet i localStorage');
    }
}

// event listener for migrerings knappen
document.getElementById('migrateFromLocal').addEventListener('click', migrateFromLocalStorage);

////////////////////// funksjoner for database og dokument "management" (finnes det er norsk ord for det?????)
// variabel for å lagre ID-en til dokumentet brukeren bruker nå
let currentDocumentId = null;

// variabel for å hente documentSearch ID-en
const documentSearch = document.getElementById('documentSearch');


documentSearch.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase(); // "e.target" = document.getElementById('documentSearch') // .value betyr at det er verdien til "documentSearch". skriver brukeren "hei hei", er .value "hei hei". // .toLowerCase betyr bare at den konverterer alt til lowercase
    const documents = document.querySelectorAll('#documentsList li');

    documents.forEach(doc => {
        const title = doc.querySelector('span').textContent.toLowerCase();
        if (title.includes(searchTerm)) {
            doc.style.display = '';
        } else {
            doc.style.display = 'none';
        }
    });
});

// funksjon for å lage nytt dokument
function createNewDocument(){
    console.log("Bruker prøver å lage nytt dokument");
    const title = prompt("Skriv inn tittel på dokumentet:", "Kult dokument på Ord Online");
    console.log("Brukeren skrev inn tittel:", title);
    // ajax :))))
    if (title) {
        fetch('save_document.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        body: JSON.stringify({
            title: title,
            content: '',
            action: 'create'
        })
    })
    .then(response => response.json())
        console.log("Fikk respons")
    .then(data => {
        if(data.success) {
            console.log("Oppretting av dokument vellykket!")
            currentDocumentId = data.documentId;
            loadDocumentsList();
            writingArea.innerHTML = '';
        }
    })
    }
}

// funksjon for å laste inn listen over dokumenter
function loadDocumentsList() {
    // ajax :-))))
    fetch('get_documents.php')
        .then(response => response.json())
        .then(documents => {
            const list = document.getElementById('documentsList');
            list.innerHTML = '';
            documents.forEach(doc => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <div class="document-item" onclick="loadDocument(${doc.id})">
                        <span>${doc.title}</span>
                    </div>
                    <div class="document-actions">
                        <button onclick="deleteDocument(${doc.id})" title="Slett dokument">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                `;
                list.appendChild(li);
            });
        });
}

function loadDocument(documentId) {
    fetch(`get_document.php?id=${documentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentDocumentId = documentId;
                writingArea.innerHTML = data.content || ''; // Hvis content er tom, sett tom string
                writingArea.contentEditable = 'true'; // gjør tekstboksen editable når brukeren har valgt et dokument
                placeholder.style.display = 'none'; // skjul placeholder teksten når et dokument er lastet inn av bruker
            }
        });
}

function saveDocument() {
    if (!currentDocumentId) return;

    fetch('save_document.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: currentDocumentId,
            content: writingArea.innerHTML,
            action: 'update'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSaveStatus('Lagret :)');
        }
    });
}

function deleteDocument(documentId) {
    if (confirm('Er du sikker på at du har lyst til å slette dette dokumentet? Gjør du det, forsvinner det for alltid, og det er ganske lenge.')) {
        fetch('delete_document.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: documentId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadDocumentsList();
                if (currentDocumentId === documentId) {
                    currentDocumentId = null;
                    writingArea.innerHTML = '';
                }
            }
        });
    }
}

// initialisering av document manager
document.getElementById('newDocument').addEventListener('click', createNewDocument);
writingArea.addEventListener('input', debounce(saveDocument, 500));
loadDocumentsList(); // laster inn dokumenter når Ord Online er åpnet

function randomSplashText(){
    const randomSplash = splashText[Math.floor(Math.random() * splashText.length)];
    kulSplash.textContent = randomSplash;
}

// auto-lagring indikator greie (viser "lagret" når den har auto lagret
function showSaveStatus(status) {
    const indicator = document.getElementById("save-status");
    indicator.textContent = status;
    indicator.style.opacity = '1';
    indicator.classList.add('status-visible'); // legger til status-visible klassen for animasjon

    setTimeout(() => {
        indicator.classList.remove('status-visible');
    }, 2000);
}

function sjekkFilNavn(filename) {
    return filename.toLowerCase().endsWith(".txt");
}

// lagre tekst som fil
function saveTextAsFile() {
    try {
        const turndownService = new TurndownService();
        console.log('TurndownService created');

        const htmlContent = document.getElementById("text-input").innerHTML;
        console.log('HTML content:', htmlContent);

        const markdownContent = turndownService.turndown(htmlContent);
        console.log('Markdown content:', markdownContent);

        let filename = prompt("Skriv inn navn på dokumentet", "ord.md");
        console.log('Filnavn:', filename)
        if (!filename)
            filename = "ord.md";

        if (!filename.toLowerCase().endsWith(".md")) {
            filename = filename + ".md";
        }

        const blob = new Blob([markdownContent], { type: "text/markdown" });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement("a");

        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Error i saveTextAsFile:', error);
        alert('Det oppstod en feil ved nedlasting av filen: ' + error.message);
    }
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
    if (!currentDocumentId) return;

    try {
        saveDocument();
    } catch (error) {
        showSaveStatus('Lagring feilet :(');
        console.error("Feil ved lagring av innhold:", error);
    }
};

// funksjon som initialiserer Ord Online
const initializer = () => {
    updateWordAndCharCount();
    randomSplashText();
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

    kulSplash.addEventListener("click", () => {
        randomSplashText();
    });

    // hvis brukeren ikke har valgt et dokument, skriv "vennligst velg et dokument"
    if (!currentDocumentId) {
            writingArea.innerHTML = '<p id="placeholder"><u><h1>Vennligst velg et dokument.</h1></u> <br> <br> <h2>   Kreditter:  </h2>  Programmering: Isak Henriksen <br> Easter egg sang: NRK <br> Dark mode inspirasjon: GitHub/Microsoft <br> <a href="https://www.youtube.com/watch?v=7lQatGnsoS8" target="_blank">Ord på Nett sangen:</a> Isak Henriksen (sangtekst) Suno AI (sanger) </p>';
    }

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
    button.addEventListener("click", (e) => {
        // stopper default actionen til clicket, som hadde tatt fokuset vekk fra writingarea
        e.preventDefault();

        modifyText(button.id, false, null);

        // ta fokuset tilbake til writingarea
        writingArea.focus();
    });
});

// valg som trenger options parameters, som for eksempel farger
advancedOptionButton.forEach((button) => {
    button.addEventListener("change", (e) => {
        e.preventDefault();
        modifyText(button.id, false, button.value);
        writingArea.focus();
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
        if (confirm("Vil du slette denne tabellen??")) {
            tableElement.closest(".table-container").remove();
        }
    }
});

////////////////// EASTER EGGS ////////////////////
writingArea.addEventListener("input", () => {
    saveContent();
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
