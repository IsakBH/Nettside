PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;

CREATE TABLE IF NOT EXISTS sjanger (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  navn TEXT NOT NULL UNIQUE
);
INSERT OR IGNORE INTO sjanger (navn) VALUES('Metal');
INSERT OR IGNORE INTO sjanger (navn) VALUES('Pop');
INSERT OR IGNORE INTO sjanger (navn) VALUES('Progrock');
INSERT OR IGNORE INTO sjanger (navn) VALUES('Rock');

CREATE TABLE IF NOT EXISTS artist (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  navn TEXT NOT NULL,
  artist_type TEXT CHECK(artist_type IN ('solo','band')) NOT NULL,
  idSjanger INTEGER,
  FOREIGN KEY (idSjanger) REFERENCES sjanger(id),
  UNIQUE(navn, artist_type)
);
INSERT OR IGNORE INTO artist (navn, artist_type, idSjanger) VALUES('The Beatles','band',1);
INSERT OR IGNORE INTO artist (navn, artist_type, idSjanger) VALUES('Beyoncé','solo',2);
INSERT OR IGNORE INTO artist (navn, artist_type, idSjanger) VALUES('Metallica','band',3);
INSERT OR IGNORE INTO artist (navn, artist_type, idSjanger) VALUES('Pink Floyd','band',4);

CREATE TABLE IF NOT EXISTS medlem (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  fullt_navn TEXT NOT NULL,
  kunstnernavn TEXT,
  fodselsdato DATE,
  land TEXT
);
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('John Lennon',NULL,'1940-10-09','UK');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Paul McCartney',NULL,'1942-06-18','UK');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('George Harrison',NULL,'1943-02-25','UK');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Ringo Starr','Ringo Starr','1940-07-07','UK');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Beyoncé Giselle Knowles-Carter','Beyoncé','1981-09-04','US');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('James Hetfield',NULL,'1963-08-03','US');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Lars Ulrich',NULL,'1963-12-26','DK');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Kirk Hammett',NULL,'1962-11-18','US');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Robert Trujillo',NULL,'1964-10-23','US');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Roger Waters',NULL,'1943-09-06','UK');
INSERT OR IGNORE INTO medlem (fullt_navn, kunstnernavn, fodselsdato, land) VALUES('Richard Wright',NULL,'1943-09-15','UK');

CREATE TABLE IF NOT EXISTS album (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  tittel TEXT NOT NULL,
  idArtist INTEGER NOT NULL,
  FOREIGN KEY (idArtist) REFERENCES artist(id)
);
INSERT OR IGNORE INTO album (tittel, idArtist) VALUES('Abbey Road',1);
INSERT OR IGNORE INTO album (tittel, idArtist) VALUES('Lemonade',2);
INSERT OR IGNORE INTO album (tittel, idArtist) VALUES('Master of Puppets',3);
INSERT OR IGNORE INTO album (tittel, idArtist) VALUES('Wish You Were Here',5);
INSERT OR IGNORE INTO album (tittel, idArtist) VALUES('The Dark Side of the Moon',5);

CREATE TABLE IF NOT EXISTS laat (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  tittel TEXT NOT NULL,
  idAlbum INTEGER,
  FOREIGN KEY (idAlbum) REFERENCES album(id)
);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Come Together',1);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Something',1);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Formation',2);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Sorry',2);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Battery',3);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Master of Puppets',3);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Shine On You Crazy Diamond',4);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Have a Cigar',4);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Speak to Me',5);
INSERT OR IGNORE INTO laat (tittel, idAlbum) VALUES('Breathe (In the Air)',5);

CREATE TABLE IF NOT EXISTS artist_medlem (
  idArtist INTEGER NOT NULL,
  idMedlem INTEGER NOT NULL,
  PRIMARY KEY (idArtist, idMedlem),
  FOREIGN KEY (idArtist) REFERENCES artist(id),
  FOREIGN KEY (idMedlem) REFERENCES medlem(id)
);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(1,1);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(1,2);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(1,3);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(1,4);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(2,5);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(3,6);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(3,7);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(3,8);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(3,9);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(5,10);
INSERT OR IGNORE INTO artist_medlem (idArtist, idMedlem) VALUES(5,11);

COMMIT;
