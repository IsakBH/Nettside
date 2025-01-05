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

const initializer = () => {
  // function calls som legger til bakgrunnsfarge / highlighter knappene som er toggled
  highlighter(alignButtons, true);
  highlighter(spacingButtons, true);
  highlighter(formatButtons, false);
  highlighter(scriptButtons, true);

  // lag valg av fonts
  fontList.map((value) => {
    let option = document.createElement("option");
    option.value = value;
    option.innerHTML = value;
    fontName.appendChild(option);
  });

  // font size
  for (let i = 1; i <= 7; i++) {
    let option = document.createElement("option");
    option.value = i;
    option.innerHTML = i;
    fontSizeRef.appendChild(option);
  }

  // default størrelsen på tekst
  fontSizeRef.value = 3;
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
