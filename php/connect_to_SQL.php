<?php

//Permet d'afficher directement les infos php sur la page
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$servername = "localhost";
$username = "umvelkior";
$password = "*BadiGaming3*";
$dbname = "TP3_reservation";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else echo "Connexion réussie";
?>
