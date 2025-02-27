<?php
include 'connect_to_SQL.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];

    // Suppression des rendez-vous associés
    $stmt = $conn->prepare("DELETE FROM rdv WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Suppression du compte utilisateur
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    session_destroy();
    echo "Compte supprimé avec succès.";
    header("Location: connection.html");

    $stmt->close();
}
?>
