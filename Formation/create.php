<?php
require_once '../database/connexion.php';

if (isset($_POST['nom'])
    && isset($_POST['description'])
    && isset($_POST['duree'])
) {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $duree = $_POST['duree'];

    $codes = $pdo->query("SELECT codeFormation FROM formations")
                 ->fetchAll(PDO::FETCH_COLUMN);
    $numero = 1;
    foreach ($codes as $code) {
        if (preg_match('/(\d+)$/', $code, $match)) {
            $numero = max($numero, (int) $match[1] + 1);
        }
    }

    $codeFormation = 'F' . $numero;

    $sql = "INSERT INTO formations (codeFormation, nomFormation, description, duration)
            VALUES (:codeFormation, :nom, :description, :duree)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':codeFormation' => $codeFormation,
        ':nom' => $nom,
        ':description' => $description,
        ':duree' => $duree
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
    <h1>Ajouter une Formation</h1>
    <form method="post">
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <br>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <br>
        <div>
            <label for="duree">Durée (en heures):</label>
            <input type="number" name="duree" id="duree" required>
        </div>
        <br>
        <button type="submit" value="Ajouter">Ajouter</button>
    </form>
    <br>

    <a href="index.php">Retour à la liste des formations</a>
</body>

</html>