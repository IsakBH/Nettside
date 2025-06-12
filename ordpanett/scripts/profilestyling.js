document.addEventListener("DOMContentLoaded", () => {
    // sjekker om user_id er lucas sin
    if (user_id === 38 || user_id === 44) {
        console.log("Hei Lucas! Dette er Herr Ord På Nett som snakker. Siden du har vært så grei og glazet Ord På Nett såpass mye, skal du få æren av å ha en gylden profil. Takk for din innsats i dette prosjektet hvor jeg tar over den digitale verden sakte men sikkert!")
        const profileElement = document.querySelector('.profile-settings');
        if (profileElement) {
            profileElement.style.backgroundColor = "gold";
        }
    }
    else {
        console.log("Du er ikke Lucas.")
    }
})