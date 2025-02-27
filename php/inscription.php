<?php
include 'connect_to_SQL.php';
include '../connection.html';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    // Vérification de l'unicité de l'email
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insertion des données
        $stmt = $conn->prepare("INSERT INTO utilisateurs (pseudo, email, mdp) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $pseudo, $email, $mdp);
        $stmt->execute();
        echo "Inscription réussie !";
    }

    $stmt->close();
}
?>
