<?php
require_once '../database/connexion.php';

$formations = $pdo->query("SELECT id, nom FROM formations ORDER BY nom")
                  ->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['nom'])
    && isset($_POST['description'])
    && isset($_POST['formation_id'])
) {
    $nom          = trim($_POST['nom']);
    $description  = trim($_POST['description']);
    $formation_id = $_POST['formation_id'];

    $sql = "INSERT INTO modules (nom, description, formation_id)
            VALUES (:nom, :description, :formation_id)";

    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':nom'          => $nom,
        ':description'  => $description,
        ':formation_id' => $formation_id
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
    <link rel="stylesheet" href="../style.css">
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