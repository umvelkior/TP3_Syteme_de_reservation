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
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <style>
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Calendrier des Rendez-vous</h1>
        <div id='calendar'></div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    <?php foreach ($rendezvous as $rdv) {
                        $date = $rdv['jour'] . 'T' . $rdv['heure'];
                        echo "{ title: '" . htmlspecialchars($rdv['commentaire'], ENT_QUOTES, 'UTF-8') . "', start: '" . $date . "' },";
                    } ?>
                ],
                locale: 'fr'
            });
            calendar.render();
        });
    </script>
</body>
</html>
