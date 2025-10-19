//   ____          _   _____        _   _      _   _
//  / __ \        | | |  __ \      | \ | |    | | | |
// | |  | |_ __ __| | | |__) |_ _  |  \| | ___| |_| |_
// | |  | | '__/ _` | |  ___/ _` | | . ` |/ _ \ __| __|
// | |__| | | | (_| | | |  | (_| | | |\  |  __/ |_| |_
//  \____/|_|  \__,_| |_|   \__,_| |_| \_|\___|\__|\__|

////////////////////////////////////////////////////////////
// Til deg som prøver å lese denne filen: beklager..      //
////////////////////////////////////////////////////////////

// lager variabler for html id-er og klasser
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
const calcButton = document.getElementById("calculator");
const calcContainer = document.getElementById("calculator-container");
const calcDisplay = document.getElementById("calc-display");
const calcButtons = document.querySelectorAll(".calc-btn");
const printButton = document.getElementById("print");
let seenEasterEgg = false;
const documentSearch = document.getElementById('documentSearch');
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
// lager liste over splash text som vises over Ord på Nett tittelen.
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
    "Live long and prosper",
    "Space, the final frontier",
    "No AI to be seen!",
    "if(cookies.accepted) { trackUser(); } else { trackUserAnyway(); }",
    "Angetreten!",
    "Achtung!",
    "Ihre befehle!",
    "Befehle!",
    "That is bullshit blazing!",
    "I am the storm that is approaching",
    "Forsakened I am awakened",
    "Vi ska bada bastu, bastu",
    "\"Kahoot = CS Cases\" - Halfdann Hesthammer",
    "\"4\" - Ivan Kuzmych",
    "En Arisk Jul",
    "Linux!!!!!",
    "Trenger jobb? Bare vær flink til å smile :)",
    "HTML er ikke koding",
    "Meat Prisoner!",
    "BBB",
    "\"Kan vi ta pause?\" - Ivan Kuzmych",
    "Has man gone insane \n A few will remain \n Who'll find a way \n To live one more day \n Through decades of war \n It spreads like disease \n There's no sign of peace \n Religion and greed \n cause to bleed \n Three decades of war",
    "Achievements?",
    "\"Achievements kommer iløpet av sommerferien\" 💔",
];

// dele dokumenter
function shareDocument(documentId) {
    fetch('create_share_link.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id: documentId })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // viser link til bruker :solbriller emotikon:
            prompt("Her er link til dokumentet ditt :) Hvem som helst kan se dokumentet, så ikke del linken med alle! Eller, du kan hvis du vil, men liksom, ja, du vet hva jeg mener. ", data.link);
        } else {
            alert("Det oppstod en feil under deling av dokument :( " + data.error);
        }
    })
}

// skriver at brukeren må velge et dokument - calles når currentDocumentId er null
function selectDocumentMessage(){
    writingArea.innerHTML = '<p id="placeholder"><u><h1 id="title">Vennligst velg et dokument.</h1></u> <br> <br> <h2>   Credits:  </h2>  Programmering: Isak Henriksen <br> Easter egg sang: NRK <br> Dark mode inspirasjon: GitHub/Microsoft <br> <a href="https://www.youtube.com/watch?v=7lQatGnsoS8" target="_blank">Ord på Nett sangen:</a> Isak Henriksen (sangtekst) Suno AI (sanger) </p>';
    console.log("Vennligst velg et dokument (skrevet via selectDocumentMessage funksjon)")
}

printButton.addEventListener("click", () => {
    printWritingArea();
    console.log("Bruker trykket på print knappen");
})

function printWritingArea() {
    if (!writingArea) {
        console.error("Ord på Nett finner ikke ID-en 'text-input', plz kontakt Isak! han har ødelagt noe!!!");
        return;
    }

    const content = writingArea.innerHTML; // henter bare innholdet av writingArea, ikke hele writingArea
    const printWindow = window.open('', '_blank');

    printWindow.document.open();
    printWindow.document.write(`
        <html>
        <head>
            <title>Print</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

document.addEventListener("DOMContentLoaded", () => {
    let expression = "";

    // toggler kalkulatoren
    calcButton.addEventListener("click", (event) => {
        event.stopPropagation(); // hindrer at klikket bobbler opp og lukker kalkisen (kalkulatoren)
        calcContainer.classList.toggle("hidden");
    });

    // lukk kalkulatoren om du trykker utenfor
    document.addEventListener("click", (event) => {
        if (!calcContainer.contains(event.target) && event.target !== calcButton) {
            calcContainer.classList.add("hidden");
        }
    });

    // trykking på kalkulator knappen
    calcButtons.forEach(button => {
        button.addEventListener("click", () => {
            const value = button.getAttribute("data-value");

            if (value) {
                expression += value;
                calcDisplay.value = expression;
            }
        });
    });

    // erlik tegn (=)
    document.getElementById("equals").addEventListener("click", () => {
        try {
            if (expression.trim() !== "") { // sjekker at expression ikke er tom
                expression = eval(expression).toString();
                calcDisplay.value = expression;
            }
        } catch {
            calcDisplay.value = "Bruk kalkulatoren riktig bro";
            expression = "";
        }
    });

    // clear knappen
    document.getElementById("clear").addEventListener("click", () => {
        expression = "";
        calcDisplay.value = "";
    });
});

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

////////////////////// funksjoner for database og dokument "management" (finnes det er norsk ord for det?????)
// variabel for å lagre ID-en til dokumentet brukeren bruker nå
let currentDocumentId = null;

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
    const music = new Audio("assets/sound/twinkle.mp3");
    music.play();
    const title = prompt("Skriv inn tittel på dokumentet:", "Skriv inn navnet her");
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
    .then(data => {
        if(data.success) {
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
                        <!--<button id="shareButton" onclick="shareDocument(${doc.id})" title="Del dokument">
                            <i class="fa-solid fa-share"></i>
                        </button>-->
                        <button onclick="deleteDocument(${doc.id})" title="Slett dokument">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                `;
                list.appendChild(li);
            });
        });
}

// funksjon for å laste inn dokumentet brukeren trykker på
function loadDocument(documentId) {
    // fjerner active-document klassen fra alle dokumenter slik at det alltid bare er ett dokument som har active-document
    document.querySelectorAll('#documentsList li').forEach(doc => {
        doc.classList.remove('active-document');
    });

    // legg til active-document på dokumentet brukeren vil ha det på
    const activeDoc = document.querySelector(`#documentsList li:has(.document-item[onclick="loadDocument(${documentId})"])`);
    if (activeDoc) {
        activeDoc.classList.add('active-document');
    }

    fetch(`get_document.php?id=${documentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentDocumentId = documentId;
                console.log("Du redigerer nå " + data.name + " med dokumentId " + currentDocumentId);
                writingArea.innerHTML = data.content || '';
                console.log("Fetchet content fra " + data.name);
                writingArea.contentEditable = 'true';
                updateWordAndCharCount();
                checkForGud();
            }
        });
}

// funksjon for å lagre dokumentene
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
            debounce(showSaveStatus('Lagret :)'), 2000);
        }
    });
}

// funksjon for å slette dokumenter
function deleteDocument(documentId) {
    if (confirm('Er du sikker på at du har lyst til å slette dette dokumentet med dokumentId ' + documentId + '? Gjør du det, forsvinner det for alltid, og det er ganske lenge.')) {
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
                    selectDocumentMessage();
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

// lagre dokument som fil
function saveTextAsFile() {
    try {
        const turndownService = new TurndownService();
        console.log("Laget turndown service")

        const htmlContent = document.getElementById("text-input").innerHTML;

        const markdownContent = turndownService.turndown(htmlContent);

        console.log("Brukeren har blitt spurt om filnavn")
        let filename = prompt("Skriv inn navn på filen");
        console.log('Bruker har skrevet inn filnavn. Filnavn:', filename)

        if (!filename){
            filename = "ordpanettdokument.md";
            console.log("Bruker skrev ikke inn filnavn! Bruker default filnavnet 'ordpanettdokument'");
        }

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
        console.log("Du lastet ned et dokument! Dokument ID: " + currentDocumentId);
    } catch (error) {
        console.error('Error i saveTextAsFile:', error);
        alert('Det oppstod en feil ved nedlasting av filen: ' + error.message);
        console.log("Det oppstod desverre en feil ved nedlasting av filen: " + error.message);
    }
}

// funksjon for å laste inn dokument fra fil
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

// funksjon som initialiserer Ord Online
const initializer = () => {
    console.log("Initialiserer Ord på Nett...");

    applyDarkMode();
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
    console.log("Splash text event listener ✓")

    // hvis brukeren ikke har valgt et dokument, skriv "vennligst velg et dokument"
    if (!currentDocumentId) {
        selectDocumentMessage();
        updateWordAndCharCount();
    }

    // legg til eventlisteners som alltid sikrer at innholdet er lagret til databasen
    writingArea.addEventListener("input", debounce(saveDocument, 2000)); // lagrer innhold hver gang bruker skriver noe med 500 ms delay via debounce funksjonen
    writingArea.addEventListener("blur", debounce(saveDocument, 500)); // lagrer når vinduet mister fokus
    window.addEventListener("beforeunload", debounce(saveDocument, 500)); // lagrer når vinduet blir unloadet (blir lukket / går i sovemodus)
    console.log("Event listeners for lagring ✓")

    console.log("Ord på Nett er ferdig initialisert!")
};

// funksjon som er nesten som en middle man og legger til delay før funksjonen du caller
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

    if (rows && cols < 100) {
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
    else {
        console.log("Hey woah woah woah woah woah, den tabellen var alt for stor! Konrad slutt å crashe Ord på Nett :(");
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
    checkForGud();
    checkForMKX();
});

// sjekker om det står "gud" i tekst boksen der brukeren skriver
function checkForGud() {
    const content = writingArea.innerText.toLowerCase();
    const crossSymbol = document.getElementById("cross-symbol");

    if (content.includes("gud" || "kristus" || "god")) {
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
            music.volume = 0.5;
            music.play();
            seenEasterEgg = true;
        }
    }
}

// tastatur snarveier
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
        else if (e.key === "k") { // desverre kan du ikke bruke e.preventDefault på Ctrl + Shift + K i firefox, så derfor må det bli ctrl + k istedet. Hadde det gått an å bruke ctrl shift k istedet, hadde jeg gjort det siden det er default i nesten alt, men men, det går bra.
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
        if (e.key === ":" && e.shiftKey) {
            e.preventDefault();
            console.log("Skriftstørrelse +1");
            let currentSize = parseInt(fontSizeRef.value);
            if (currentSize < 7) {
                fontSizeRef.value = currentSize + 1;
                modifyText("fontSize", false, currentSize + 1);
            }
        }

        // -1 skriftstørrelse
        if (e.key === ";" && e.shiftKey) {
            e.preventDefault();
            console.log("Skriftstørrelse -1");
            let currentSize = parseInt(fontSizeRef.value);
            if (currentSize > 1) {
                fontSizeRef.value = currentSize - 1;
                modifyText("fontSize", false, currentSize - 1);
            }
        }

        if (e.key === "j") {
            e.preventDefault();
            randomSplashText();
            console.log("Bruker endret splash text.");
        }

        if (e.key === "p") {
            e.preventDefault();
            printWritingArea();
            console.log("Bruker brukte hotkey for printWritingArea()")
        }

        // focuse documentsearch
        if (e.key === "l") {
            e.preventDefault();
            console.log("Bruker brukte snarvei for å selecte / focuse på documentSearch");
            documentSearch.focus();
        }

        if (e.key === "d") {
            e.preventDefault();
            console.log("Bruker brukte snarvei for å toggle dark mode");
            toggleDarkMode();
        }
    }
};

window.onload = initializer();
