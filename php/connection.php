<?php
include 'connect_to_SQL.php';
include 'connection.html';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($mdp, $user['mdp'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../profile.html");
    } 
    else {
        echo "Email ou mot de passe incorrect.";
    }

    $stmt->close();
}

?>
