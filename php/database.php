
<!DOCTYPE html>
<html lang="no">

<head>
    <title> kul php </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
</head>

<style>
#leggtileier{
    justify-content: center;
    text-align: center;
    margin: 0 auto;
    background-color: aliceblue;
    padding: 30px;
    border-radius: 30px;
    width: 50%;
}

#input {
    background-color: white;
    text-decoration: 0;
    border: 1px solid grey;
    border-radius: 5px;
    padding: 5px;
}

#input:hover {
    background-color: #eee;
}

#input:focus {
    outline: none;
}
</style>

<body>
    <form id="leggtileier" action="database.php" method="post">
        <label>
            Personnummer:
        </label> <br>
            <input id="input" type="text" name="personnummer"> <br>
        <label>
            Fornavn:
        </label> <br>
            <input id="input" type="text" name="fornavn"> <br>
        <label>
            Etternavn:
        </label> <br>
            <input id="input" type="text" name="etternavn"> <br>
        <label>
            Mobil:
        </label> <br>
            <input id="input" type="text" name="mobil"> <br>
        <label>
            Epost:
        </label> <br>
            <input id="input" type="text" name="epost"> <br>
        <label>
            Postnummer:
        </label> <br>
            <input id="input" type="text" name="postnummer"> <br>
            <label>
                Registreringsnummer:
        </label> <br>
            <input id="input" type="text" name="registreringsnummer"> <br>
        <input type="submit" name="submit" value="Legg til data">
    </form>
</body>

</html>


<?php
$db_server = "localhost";
$db_user = "isak";
$db_pass = "some_pass";
$db_name = "test_db";
$conn = "";

// koble til serveren
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// sjekk tilkobling
if (!$conn) {
    die("Tilkobling feilet: <br>" . mysqli_connect_error());
} else {
    echo "Tilkoblet database <br>";
}

/*
// sjekker serverinfo
echo "serverinfo " . mysqli_get_server_info($conn);
*/

////////////////////////////////////////////

// henter verdien til username med POST
// henter verdien til password med POST
$personnummer = $_POST["personnummer"];
$fornavn  = $_POST["fornavn"];
$etternavn  = $_POST["etternavn"];
$mobil  = $_POST["mobil"];
$epost  = $_POST["epost"];
$postnummer  = $_POST["postnummer"];
$registreringsnummer  = $_POST["registreringsnummer"];

//$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO eier VALUES ('$personnummer', '$fornavn', '$etternavn', '$mobil', '$epost', '$postnummer', '$registreringsnummer');";

$query = mysqli_query($conn, $sql);

if ($query) {
    echo "Lagt til eier. <br>";
} else {
    echo "SQL ERROR" . mysqli_error($conn) . "<br>";
}

$sql = "SELET * FROM eier WHERE fornavn = 'Viggo'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo $row["personnummer"] . "<br>";
    echo $row["fornavn"] . "<br>";
}

mysqli_close($conn);


?>
