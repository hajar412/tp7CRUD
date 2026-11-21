<?php
require_once "../database/connexion.php";

if (!isset($_GET["id"]) || $_GET["id"] === "") {
    die("ID manquant.");
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM modules WHERE codeModule = :id");
$statement->execute(["id" => $id]);
$module = $statement->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    die("Module introuvable.");
}

$formations = $pdo->query(
    "SELECT codeFormation, nomFormation FROM formations ORDER BY nomFormation"
)
                  ->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["nom"], $_POST["description"], $_POST["codeFormation"])) {
        die("Informations du formulaire manquantes.");
    }

    $sql = "UPDATE modules
            SET nomModule = :nom, description = :description, codeFormation = :codeFormation
            WHERE codeModule = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "nom" => trim($_POST["nom"]),
        "description" => trim($_POST["description"]),
        "codeFormation" => $_POST["codeFormation"],
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
    <title>Centre - Modifier un module</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

    <h1>Modifier un module</h1>
    <form method="POST">

        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom"
                   value="<?php echo htmlspecialchars($module["nomModule"]); ?>" required>
        </div>

        <br>

        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" cols="40"><?php echo htmlspecialchars($module["description"] ?? ""); ?></textarea>
        </div>

        <br>

        <div>
            <label for="codeFormation">Formation :</label>
            <select id="codeFormation" name="codeFormation" required>
                <?php foreach ($formations as $f) { ?>
                    <option value="<?php echo htmlspecialchars($f["codeFormation"], ENT_QUOTES, "UTF-8"); ?>"
                        <?php if ($f["codeFormation"] == $module["codeFormation"]) { echo "selected"; } ?>>
                        <?php echo htmlspecialchars($f["nomFormation"]); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <br>

        <button type="submit">Modifier</button>

    </form>

    <br>

    <a href="index.php">Retour</a>

</body>

</html>