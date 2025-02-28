<?php
include 'connect_to_SQL.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $jour = $_POST['jour'];
    $heure = $_POST['heure'];
    $commentaire = $_POST['commentaire'];

    $stmt = $conn->prepare("SELECT * FROM rdv WHERE jour = ? AND heure = ?");
    $stmt->bind_param("ss", $jour, $heure);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Ce créneau horaire est déjà pris.";
    } 
    else {
        $stmt = $conn->prepare("INSERT INTO rdv (user_id, jour, heure, commentaire) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $jour, $heure, $commentaire);
        $stmt->execute();
        echo "Rendez-vous enregistré !";
        header("Location: calendrier.php");
    }

    $stmt->close();
}
?>
