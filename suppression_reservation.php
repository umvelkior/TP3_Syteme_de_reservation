<?php
session_start();
include 'connect_to_SQL.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connection.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les rendez-vous de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM rdv WHERE user_id = ? ORDER BY jour, heure");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$rendezvous = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_stmt = $conn->prepare("DELETE FROM rdv WHERE id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $delete_id, $user_id);
    $delete_stmt->execute();
    header("Location: calendrier.php");
    exit();
}
?>
