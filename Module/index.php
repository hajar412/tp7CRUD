<?php
require_once '../database/connexion.php';

$sql = "SELECT m.codeModule AS id, m.nomModule AS nom, m.description,
               f.nomFormation AS formation
        FROM modules m
        INNER JOIN formations f ON f.codeFormation = m.codeFormation";
$modules = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Centre - Modules</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body class="dashboard-page">
    <div class="page-shell">
    <header class="page-topbar"><a class="home-link" href="../index.php">← Accueil</a><span class="page-caption">CENTRE DE FORMATION / MODULES</span></header>
    <div class="page-heading"><div><div class="eyebrow">RÉPERTOIRE</div><h1>Liste des modules</h1><p>Consultez et gérez les modules de chaque formation.</p></div><a class="btn btn-primary" href="create.php">
        Ajouter un module
    </a></div>

    <br><br>

    <div class="content-card"><div class="table-wrap"><table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Formation</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($modules as $module) { ?>

                <tr>

                    <td>
                        <?php echo $module["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($module["nom"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($module["description"] ?? ""); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($module["formation"]); ?>
                    </td>

                    <td>

                        <a href="edit.php?id=<?php echo $module["id"]; ?>">
                            Modifier
                        </a>

                        |

                        <a href="delete.php?id=<?php echo urlencode($module["id"]); ?>"
                           onclick="return confirm('Supprimer ce module ?');">
                            Supprimer
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table></div></div>

      <a href="../index.php" style="display:block;width:max-content;margin:20px auto 40px;">Retour</a>
    </div>

</body>

</html>