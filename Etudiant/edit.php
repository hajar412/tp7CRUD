<?php
require_once "../database/connexion.php";

if (!isset($_GET["id"]) || $_GET["id"] === "") {
    die("ID manquant.");
}

$id = (int) $_GET["id"];
$statement = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
$statement->execute(["id" => $id]);
$etudiant = $statement->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
}

$formations = $pdo->query(
    "SELECT codeFormation, nomFormation FROM formations ORDER BY nomFormation"
)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["codeFormation"])) {
        die("Informations du formulaire manquantes.");
    }

    $sql = "UPDATE etudiants
            SET nom = :nom, prenom = :prenom, email = :email,
                codeFormation = :codeFormation
            WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "nom" => trim($_POST["nom"]),
        "prenom" => trim($_POST["prenom"]),
        "email" => trim($_POST["email"]),
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
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h1>Modifier un étudiant</h1>
    <form method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom"
               value="<?php echo htmlspecialchars($etudiant["nom"], ENT_QUOTES, "UTF-8"); ?>" required>
        <br><br>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom"
               value="<?php echo htmlspecialchars($etudiant["prenom"], ENT_QUOTES, "UTF-8"); ?>" required>
        <br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($etudiant["email"], ENT_QUOTES, "UTF-8"); ?>" required>
        <br><br>
        <label for="codeFormation">Formation :</label>
        <select id="codeFormation" name="codeFormation" required>
            <?php foreach ($formations as $formation) { ?>
                <option value="<?php echo htmlspecialchars($formation["codeFormation"], ENT_QUOTES, "UTF-8"); ?>"
                    <?php if ($formation["codeFormation"] === $etudiant["codeFormation"]) echo "selected"; ?>>
                    <?php echo htmlspecialchars($formation["nomFormation"], ENT_QUOTES, "UTF-8"); ?>
                </option>
            <?php } ?>
        </select>
        <br><br>
        <button type="submit">Modifier</button>
    </form>
    <br>
    <a href="index.php">Retour</a>
</body>
</html>