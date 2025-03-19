<?php
$servername = "localhost";
$username = "nume_utilizator_bd";
$password = "parola_bd";
$dbname = "nume_bd";

// Crează conexiunea
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifică conexiunea
if (!$conn) {
    die("Conexiune eșuată: " . mysqli_connect_error());
}
?>