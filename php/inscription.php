<?php
include 'connect_to_SQL.php';
include '../connection.html';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    $date_de_naissance = $_POST['date_de_naissance'];
    $numero_telephone = $_POST['numero_telephone'];

    // Vérification de l'unicité de l'email
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insertion des données
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, date_de_naissance, numero_telephone, email, mdp) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nom, $prenom, $date_de_naissance, $numero_telephone, $email, $mdp);
        $stmt->execute();
        echo "Inscription réussie !";
    }

    $stmt->close();
}
?>
