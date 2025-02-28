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
                            <a class="nav-link" href="calendrier.php">
                                <div class="column">
                                    <p class="d-flex justify-content-center nav-lien">Calendrier</p>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
    <section class="container-fluid">
        <nav aria-label="...">
            <ul class="pagination pagination-lg d-flex justify-content-center">
                <li class="page-item" aria-current="page">
                    <a class="page-link" href="#"  onclick="showContainerbis('rdv_container')">Réserver</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" onclick="showContainerbis('liste_container')">Supprimer</a>
                </li>
            </ul>
        </nav>

        <section class="container" id="rdv_container">
            <div class="container">
            <h1 class="my-4">Prendre un Rendez-vous</h1>
            <?php
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: connection.html");
                exit();
            }
            ?>
            <form action="reservation.php" method="POST">
                <div class="form-group">
                    <label for="jour">Date</label>
                    <input type="date" class="form-control" id="jour" name="jour" required>
                </div>
                <div class="form-group">
                    <label for="heure">Heure PT</label>
                    <select class="form-control" id="heure" name="heure" required>
                        <?php
                        for ($h = 8; $h < 18; $h++) {
                            for ($m = 0; $m < 60; $m += 30) {
                                $heure = sprintf("%02d:%02d", $h, $m);
                                echo "<option value=\"$heure\">$heure</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="commentaire">Commentaire</label>
                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Prendre Rendez-vous</button>
            </form>
        </div>
    </section>

    <section class="container " id="liste_container"></section>
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
    </section>
    </section>
    <section class="container" id="calendrier_container"></section>
        <div class="container">
            <h1 class="my-4">Calendrier des Rendez-vous</h1>
            <div id='calendar'></div>
        </div>
    </section>
    </main>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='js/script.js'></script>
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
