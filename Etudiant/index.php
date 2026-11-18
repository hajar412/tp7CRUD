<?php
require_once '../database/connexion.php';

$sql = "SELECT e.id, e.nom, e.prenom, e.email,
               f.nomFormation AS formation
        FROM etudiants e
        INNER JOIN formations f ON f.codeFormation = e.codeFormation";
$etudiants = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Centre - Étudiants</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/pages.css">
</head>

<body class="dashboard-page">
    <div class="page-shell">
    <header class="page-topbar">
        <a class="home-link" href="../index.php">← Accueil</a>
        <span class="page-caption">CENTRE DE FORMATION / ÉTUDIANTS</span>
    </header>
    <div class="page-heading">
        <div>
            <div class="eyebrow">RÉPERTOIRE</div>
            <h1>Liste des étudiants</h1>
            <p>Consultez et gérez les étudiants et leur formation.</p>
        </div>
        <a class="btn btn-primary" href="create.php">
        Ajouter un étudiant
        </a>
    </div>

    <br><br>

    <div class="content-card">
        <div class="table-wrap">
            <table>

                <thead>
                <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Formation</th>
                <th>Actions</th>
                </tr>
                </thead>

                <tbody>

            <?php foreach ($etudiants as $etudiant) { ?>

                <tr>

                    <td>
                        <?php echo $etudiant["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($etudiant["nom"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($etudiant["prenom"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($etudiant["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($etudiant["formation"]); ?>
                    </td>

                    <td>

                        <a href="edit.php?id=<?php echo $etudiant["id"]; ?>">
                            Modifier
                        </a>

                        |

                        <a href="delete.php?id=<?php echo $etudiant["id"]; ?>">
                            Supprimer
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>
</div>

</div>

</div>

</body>

</html>
