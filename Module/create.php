<?php
require_once '../database/connexion.php';

$formations = $pdo->query(
    "SELECT codeFormation, nomFormation FROM formations ORDER BY nomFormation"
)
                  ->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['nom'])
    && isset($_POST['description'])
    && isset($_POST['codeFormation'])
) {
    $nom          = trim($_POST['nom']);
    $description  = trim($_POST['description']);
    $codeFormation = $_POST['codeFormation'];

    $codes = $pdo->query("SELECT codeModule FROM modules")
                 ->fetchAll(PDO::FETCH_COLUMN);
    $numero = 101;
    foreach ($codes as $code) {
        if (preg_match('/(\d+)$/', $code, $match)) {
            $numero = max($numero, (int) $match[1] + 1);
        }
    }

    $codeModule = 'M' . $numero;

    $sql = "INSERT INTO modules (codeModule, nomModule, description, codeFormation)
            VALUES (:codeModule, :nom, :description, :codeFormation)";

    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':codeModule'   => $codeModule,
        ':nom'          => $nom,
        ':description'  => $description,
        ':codeFormation' => $codeFormation
    ]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une Formation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h1>Ajouter un module</h1>
    <form method="post">
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <br>
        <div>
            <label for="codeFormation">Formation:</label>
            <select name="codeFormation" id="codeFormation" required>
                <option value="">Choisir une formation</option>
                <?php foreach ($formations as $formation) { ?>
                    <option value="<?php echo htmlspecialchars($formation['codeFormation'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($formation['nomFormation'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <br>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <br>
        <button type="submit" value="Ajouter">Ajouter</button>
    </form>
    <br>

    <a href="index.php">Retour à la liste des module</a>
</body>
</html>