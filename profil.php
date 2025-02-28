<?php
include 'connect_to_SQL.php';
include 'profil.html';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: connection.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $numero_telephone = $_POST['numero_telephone'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
    } 
    else 
    {
        $stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, date_de_naissance = ?, numero_telephone = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nom, $prenom, $date_de_naissance, $numero_telephone, $email, $user_id);
        $stmt->execute();
        echo "Informations mises à jour !";
        header("Location: profil.php");
    }

    $stmt->close();
}
?>
