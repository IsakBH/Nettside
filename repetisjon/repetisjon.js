const sqlite3 = require('better-sqlite3')
db  = sqlite3('musikk.db')

function getSjanger(id) {
    let sql = global.db.prepare("select navn from sjanger where id = ?")
    let result = sql.get(id);
    return result.navn
}

 function getArtists() {
    let sql = global.db.prepare("select id, navn, artist_type, idSjanger from artist")
    let result = sql.all();
    return result
}

function getAlbum(id) {
    let sql = global.db.prepare("select tittel from album where idArtist = ?");
    let result = sql.tittel;
    return result.tittel;
}

function getSongs(id) {
    let sql = global.db.prepare("select tittel from laat where albumId = ?");
    let result = sql.get(tittel);
    return result.tittel;
}

const artister = getArtists()
for (let artist of artister) {
    const sjanger = getSjanger(artist.idSjanger)
    const album = getAlbum(artist.id);
    console.log(artist.id, artist.navn, sjanger, album)
}

/*Hent ut alle laater og album for alle artister, og skriv ut i følgende format i console
The Beatles
  Album: Abbey Road
  Låter: Come Together, Something
Beyonce
   Album: Lemonade
   Låter: Formation, Sorry
Og resten av artistene og låtene
*/
