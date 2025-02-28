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

// Supprimer un rendez-vous si demandé
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_stmt = $conn->prepare("DELETE FROM rdv WHERE id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $delete_id, $user_id);
    $delete_stmt->execute();
    header("Location: suppression_reservation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Rendez-vous</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                <li class="nav-item">
                        <div class="container">
                            <a class="nav-link" href="profil.php">
                                <div class="column">
                                    <p class="d-flex justify-content-center nav-lien">Profil</p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="container">
                            <a class="nav-link" href="reservation.php">
                                <div class="column">
                                    <p class="d-flex justify-content-center nav-lien">Réserver</p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="container">
                            <a class="nav-link" href="calendrier.php">
                                <div class="column">
                                    <p class="d-flex justify-content-center nav-lien">Calendrier</p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="container">
                            <a class="nav-link" href="suppression_reservation.php">
                                <div class="column">
                                    <p class="d-flex justify-content-center nav-lien">Gérer mes rendez-vous</p>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
    <div class="container">
        <h1 class="my-4">Liste des Rendez-vous</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Commentaire</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rendezvous as $rdv) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rdv['jour']); ?></td>
                        <td><?php echo htmlspecialchars($rdv['heure']); ?></td>
                        <td><?php echo htmlspecialchars($rdv['commentaire']); ?></td>
                        <td>
                            <form method="POST" action="suppression_reservation.php" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $rdv['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </main>
</body>
</html>
