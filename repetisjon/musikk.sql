PRAGMA foreign_keys = OFF;

BEGIN TRANSACTION;

CREATE TABLE medlem (
    id INTEGER PRIMARY KEY,
    fullt_navn TEXT NOT NULL,
    kunstnernavn TEXT,
    fodselsdato DATE,
    land TEXT
);

INSERT INTO
    medlem
VALUES
    (1, 'John Lennon', NULL, '1940-10-09', 'UK');

INSERT INTO
    medlem
VALUES
    (2, 'Paul McCartney', NULL, '1942-06-18', 'UK');

INSERT INTO
    medlem
VALUES
    (3, 'George Harrison', NULL, '1943-02-25', 'UK');

INSERT INTO
    medlem
VALUES
    (
        4,
        'Ringo Starr',
        'Ringo Starr',
        '1940-07-07',
        'UK'
    );

INSERT INTO
    medlem
VALUES
    (
        5,
        'Beyoncé Giselle Knowles-Carter',
        'Beyoncé',
        '1981-09-04',
        'US'
    );

INSERT INTO
    medlem
VALUES
    (6, 'James Hetfield', NULL, '1963-08-03', 'US');

INSERT INTO
    medlem
VALUES
    (7, 'Lars Ulrich', NULL, '1963-12-26', 'DK');

INSERT INTO
    medlem
VALUES
    (8, 'Kirk Hammett', NULL, '1962-11-18', 'US');

INSERT INTO
    medlem
VALUES
    (9, 'Robert Trujillo', NULL, '1964-10-23', 'US');

CREATE TABLE artist_medlem (
    idArtist INTEGER NOT NULL,
    idMedlem INTEGER NOT NULL,
    PRIMARY KEY (idArtist, idMedlem),
    FOREIGN KEY (idArtist) REFERENCES artist (id),
    FOREIGN KEY (idMedlem) REFERENCES medlem (id)
);

INSERT INTO
    artist_medlem
VALUES
    (1, 1);

INSERT INTO
    artist_medlem
VALUES
    (1, 2);

INSERT INTO
    artist_medlem
VALUES
    (1, 3);

INSERT INTO
    artist_medlem
VALUES
    (1, 4);

INSERT INTO
    artist_medlem
VALUES
    (2, 5);

INSERT INTO
    artist_medlem
VALUES
    (3, 6);

INSERT INTO
    artist_medlem
VALUES
    (3, 7);

INSERT INTO
    artist_medlem
VALUES
    (3, 8);

INSERT INTO
    artist_medlem
VALUES
    (3, 9);

CREATE TABLE laat (
    id INTEGER PRIMARY KEY,
    tittel TEXT NOT NULL,
    idAlbum INTEGER,
    FOREIGN KEY (idAlbum) REFERENCES album (id)
);

INSERT INTO
    laat
VALUES
    (1, 'Come Together', 1);

INSERT INTO
    laat
VALUES
    (2, 'Something', 1);

INSERT INTO
    laat
VALUES
    (3, 'Formation', 2);

INSERT INTO
    laat
VALUES
    (4, 'Sorry', 2);

INSERT INTO
    laat
VALUES
    (5, 'Battery', 3);

INSERT INTO
    laat
VALUES
    (6, 'Master of Puppets', 3);

CREATE TABLE sjanger (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    navn TEXT NOT NULL UNIQUE
);

INSERT INTO
    sjanger
VALUES
    (1, 'Rock');

INSERT INTO
    sjanger
VALUES
    (2, 'Pop');

INSERT INTO
    sjanger
VALUES
    (3, 'Metal');

CREATE TABLE album (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tittel TEXT NOT NULL,
    idArtist INTEGER NOT NULL,
    FOREIGN KEY (idArtist) REFERENCES artist (id)
);

INSERT INTO
    album
VALUES
    (1, 'Abbey Road', 1);

INSERT INTO
    album
VALUES
    (2, 'Lemonade', 2);

INSERT INTO
    album
VALUES
    (3, 'Master of Puppets', 3);

CREATE TABLE artist (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    navn TEXT NOT NULL,
    artist_type TEXT NOT NULL CHECK (artist_type IN ('solo', 'band')),
    idSjanger INTEGER,
    FOREIGN KEY (idSjanger) REFERENCES sjanger (id),
    UNIQUE (navn, artist_type)
);

INSERT INTO
    artist
VALUES
    (1, 'The Beatles', 'band', 1);

INSERT INTO
    artist
VALUES
    (2, 'Beyoncé', 'solo', 2);

INSERT INTO
    artist
VALUES
    (3, 'Metallica', 'band', 3);

INSERT INTO
    sqlite_sequence
VALUES
    ('sjanger', 3);

INSERT INTO
    sqlite_sequence
VALUES
    ('album', 3);

INSERT INTO
    sqlite_sequence
VALUES
    ('artist', 3);

COMMIT;
