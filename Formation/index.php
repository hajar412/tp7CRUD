<?php
require_once '../database/connexion.php';

$sql = "SELECT codeFormation AS id, nomFormation AS nom, description,
               duration AS duree
        FROM formations";
$formations = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Centre - Formations</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/pages.css">
</head>

<body class="dashboard-page">
    <div class="page-shell">
    <header class="page-topbar"><a class="home-link" href="../index.php">← Accueil</a><span class="page-caption">CENTRE DE FORMATION / FORMATIONS</span></header>
    <div class="page-heading"><div><div class="eyebrow">RÉPERTOIRE</div><h1>Liste des formations</h1><p>Consultez et gérez les formations du centre.</p></div><a class="btn btn-primary" href="create.php">
        Ajouter une formation
    </a></div>

    <br><br>

    <div class="content-card"><div class="table-wrap"><table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Durée (mois)</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($formations as $formation) { ?>

                <tr>

                    <td>
                        <?php echo $formation["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($formation["nom"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($formation["description"] ?? ""); ?>
                    </td>

                    <td>
                        <?php echo $formation["duree"]; ?>
                    </td>

                    <td>

                        <a href="edit.php?id=<?php echo $formation["id"]; ?>">
                            Modifier
                        </a>

                        |

                        <a href="delete.php?id=<?php echo $formation["id"]; ?>">
                            Supprimer
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table></div></div>

    </div>

</body>

</html>