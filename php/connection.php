<?php
include 'connect_to_SQL.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    // Vérification de l'unicité de l'email
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insertion des données
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $email, $mot_de_passe);
        $stmt->execute();
        echo "Inscription réussie !";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>
