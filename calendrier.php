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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calendrier des Rendez-vous</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }
        .day {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .event {
            background-color: #f0ad4e;
            padding: 5px;
            margin: 5px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Calendrier des Rendez-vous</h1>
        <div class="calendar">
            <?php
            $daysOfWeek = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            foreach ($daysOfWeek as $day) {
                echo "<div class='day'><strong>$day</strong></div>";
            }

            // Afficher les rendez-vous
            foreach ($rendezvous as $rdv) {
                $date = new DateTime($rdv['jour']);
                $dayOfWeek = $date->format('N') - 1; // 0 pour Lundi, 6 pour Dimanche
                $dayCell = "<div class='day'>" . $date->format('d/m/Y') . "<br>";
                $dayCell .= "<div class='event'>" . $rdv['heure'] . " - " . $rdv['commentaire'] . "</div>";
                $dayCell .= "</div>";
                echo str_repeat("<div class='day'></div>", $dayOfWeek) . $dayCell;
            }
            ?>
        </div>
    </div>
</body>
</html>
