<?php
require_once '../database/connexion.php';

$formations = $pdo->query(
    "SELECT codeFormation, nomFormation FROM formations ORDER BY nomFormation"
)
                  ->fetchAll(PDO::FETCH_ASSOC);

$erreur = null;

if (
    isset($_POST['nom'])
    && isset($_POST['prenom'])
    && isset($_POST['email'])
    && isset($_POST['codeFormation'])
) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $codeFormation = $_POST['codeFormation'];

    $sql = "INSERT INTO etudiants (nom, prenom, email, codeFormation)
            VALUES (:nom, :prenom, :email, :codeFormation)";

    try {
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':codeFormation' => $codeFormation
        ]);
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        $mysqlErrorCode = $e->errorInfo[1] ?? null;
        if ($e->getCode() === '23000' && (int) $mysqlErrorCode === 1062) {
            $erreur = 'Cet e-mail existe déjà.';
        } else {
            throw $e;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un Étudiant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h1>Ajouter un Étudiant</h1>
    <form action="create.php" method="post">
        <?php if ($erreur !== null) { ?>
            <p class="form-error" role="alert"><?php echo htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php } ?>
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <br>

        <div>
            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($_POST['prenom'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <br>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <br>

        <div>
            <label for="codeFormation">Formation:</label>
            <select name="codeFormation" id="codeFormation" required>
                <option value="">Choisir une formation</option>
                <?php foreach ($formations as $formation) { ?>
                    <option value="<?php echo htmlspecialchars($formation['codeFormation'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo isset($_POST['codeFormation']) && $_POST['codeFormation'] === $formation['codeFormation'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($formation['nomFormation'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <br>

        <button type="submit" value="Ajouter">Ajouter</button>
    </form>
    <br>
    <a href="index.php">Retour à la liste des étudiants</a>

</body>
</html>