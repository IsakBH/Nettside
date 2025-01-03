const choices = ["stein", "papir", "saks"];
const playerDisplay = document.getElementById("playerDisplay");
const computerDisplay = document.getElementById("computerDisplay");
const resultDisplay = document.getElementById("resultDisplay");
const playerScoreDisplay = document.getElementById("playerScoreDisplay");
const computerScoreDisplay = document.getElementById("computerScoreDisplay");
let playerScore = 0;
let computerScore = 0;

function playGame(playerChoice) {
    const computerChoice = choices[Math.floor(Math.random() * 3)]; // * 3 sikrer at random indexen dekker hele rekkevidden av arrayen. hadde du byttet størrelsen på arrayen måtte du byttet denne også. (eller så kunne du bare skrevet choices.length)

    let result = "";

    if (playerChoice === computerChoice) {
        result = "Uavgjort :|";
    } else {
        switch (playerChoice) {
            case "stein":
                result = computerChoice === "saks" ? "Du vant! :)" : "Du tapte :(";
                document.getElementById('resultDisplay').style.visibility = 'visible';
                break;

            case "papir":
                result = computerChoice === "stein" ? "Du vant! :)" : "Du tapte :(";
                document.getElementById('resultDisplay').style.visibility = 'visible';
                break;

            case "saks":
                result = computerChoice === "papir" ? "Du vant! :)" : "Du tapte :(";
                document.getElementById('resultDisplay').style.visibility = 'visible';
                break;
        }
    }

    playerDisp|lay.textContent = `Spiller: ${playerChoice}`;
    computerDisplay.textContent = `Maskin: ${computerChoice}`;

    resultDisplay.textContent = result;
    switch (result) {
        case "Du vant! :)":
            playerScore++;
            playerScoreDisplay.textContent = playerScore;

            break;

        case "Du tapte :(":
            computerScore++;
            computerScoreDisplay.textContent = computerScore;

            break;
    }
}
