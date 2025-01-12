<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isak Henriksen</title>
    <link rel="stylesheet" href="testing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
</head>
<body>
    <header>
        <img class="bio"src="isakbilde.jpg" alt="Bilde av meg" id="biopic">
        <h1 class="bio">Isak Henriksen</h1>
        <p class="bio">Svært kul utvikler basert i Bergen</p>
        <button class="headercontact">+47 458 48 234</button>
        <button class="headercontact">isak@brunhenriksen.net</button>
    </header>

    <nav>
        <a href="#arbeid">Arbeid</a>
        <a href="#om">Om</a>
        <a href="#kontakt">Kontakt</a>
    </nav>

    <!-- Arbeid seksjonen-->
    <section id="arbeid">
        <div class="projects">
            <div class="project-card">
                <h3>Tekst editor</h3>
                <p>En veldig simpel tekst editor med et enkelt brukergrensesnitt.</p>
                <li>
                    <ul><a href="https://isak.brunhenriksen.no/Texteditor/" target="_blank">Ord Online</a></ul>
                </li>

                <li>
                    <ul><a href="https://www.github.com/isakbh/Ord-text-editor" target="_blank">Ord GTK</a></ul>
                </li>
            </div>

            <div class="project-card">
                <h3>Fotoserie</h3>
                <p> En foto serie med 5 bilder og en video. </p>
                <span>Side under utvikling</span>
            </div>

            <div class="project-card">
                <h3>Galleri side</h3>
                <p>Veldig simpel galleri side (snart med database for lagring av bilder).</p>
                <li>
                <ul>
                <a href="https://isak.brunhenriksen.no/Undersider/galleri.php" target="_blank">Galleri</a>
                </ul>
                </li>
            </div>
        </div>
    </section>

    <!-- Om seksjonen-->
    <section id="om">
        <h2>Om meg</h2>
        <hr>
        <p>
            Jeg er en utvikler med fokus på clean kode og brukeropplevelse.
            Jobber med Javascript og PHP for webutvikling og Rust og Python for andre ting.
        </p>
        <hr>
        <p><i class="fa-solid fa-location-dot"></i> Bergen, Norge</p>
        <p><i class="fa-solid fa-graduation-cap"></i>Amalie Skram videregående skole</p>
        <p><i class="fa-solid fa-globe"></i>https://isak.brunhenriksen.no</p>
    </section>

    <!-- Kontakt seksjonen-->
    <section id="kontakt" class="contact">
        <a href="mailto:isak@brunhenriksen.net" target="_blank">isak@brunhenriksen.net</a>
        <a href="https://github.com/isakbh" target="_blank">GitHub</a>
        <a href="https://linkedin.com/in/isak-henriksen-272565346/" target="_blank">LinkedIn</a>
    </section>
</body>
</html>
