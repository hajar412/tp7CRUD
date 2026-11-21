<?php
require_once '../database/connexion.php';

$erreur = null;

if (isset($_POST['nom'])
    && isset($_POST['description'])
    && isset($_POST['duree'])
) {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $duree = $_POST['duree'];

    $nomSansSeparateurs = preg_replace('/[^\p{L}]/u', '', $nom);
    if ($nomSansSeparateurs === null || $nomSansSeparateurs === '') {
        $erreur = 'Le nom de la formation doit contenir au moins une lettre.';
    } else {
        $codeFormation = mb_strtoupper(
            mb_substr($nomSansSeparateurs, 0, 4, 'UTF-8'),
            'UTF-8'
        );

        $sql = "INSERT INTO formations (codeFormation, nomFormation, description, duration)
                VALUES (:codeFormation, :nom, :description, :duree)";

        try {
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':codeFormation' => $codeFormation,
                ':nom' => $nom,
                ':description' => $description,
                ':duree' => $duree
            ]);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $mysqlErrorCode = $e->errorInfo[1] ?? null;
            if ($e->getCode() === '23000' && (int) $mysqlErrorCode === 1062) {
                $erreur = 'Une formation utilise déjà cet identifiant. Choisissez un nom avec quatre premières lettres différentes.';
            } else {
                throw $e;
            }
        }
    }
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
        <?php if ($erreur !== null) { ?>
            <p class="form-error" role="alert"><?php echo htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php } ?>
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <br>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <br>
        <div>
            <label for="duree">Durée (en heures):</label>
            <input type="number" name="duree" id="duree" min="1" value="<?php echo htmlspecialchars($_POST['duree'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <br>
        <button type="submit" value="Ajouter">Ajouter</button>
    </form>
    <br>

    <a href="index.php">Retour à la liste des formations</a>
</body>

</html>