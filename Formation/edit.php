<?php
require_once "../database/connexion.php";

if (!isset($_GET["id"]) || $_GET["id"] === "") {
    die("ID manquant.");
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM formations WHERE codeFormation = :id");
$statement->execute(["id" => $id]);
$formation = $statement->fetch(PDO::FETCH_ASSOC);

if (!$formation) {
    die("Formation introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["nom"], $_POST["description"], $_POST["duree"])) {
        die("Informations du formulaire manquantes.");
    }

    $sql = "UPDATE formations
            SET nomFormation = :nom, description = :description, duration = :duree
            WHERE codeFormation = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "nom" => trim($_POST["nom"]),
        "description" => trim($_POST["description"]),
        "duree" => $_POST["duree"],
        "id" => $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Centre - Modifier une formation</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

    <h1>Modifier une formation</h1>
    <form method="POST">

        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom"
                   value="<?php echo htmlspecialchars($formation["nomFormation"]); ?>" required>
        </div>

        <br>

        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" cols="40"><?php echo htmlspecialchars($formation["description"] ?? ""); ?></textarea>
        </div>

        <br>

        <div>
            <label for="duree">Durée (heures) :</label>
            <input type="number" id="duree" name="duree" min="1"
                   value="<?php echo htmlspecialchars($formation["duration"]); ?>" required>
        </div>

        <br>

        <button type="submit">Modifier</button>

    </form>

    <br>

    <a href="index.php">Retour</a>

</body>

</html>