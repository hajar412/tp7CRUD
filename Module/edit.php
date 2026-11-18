<?php
require_once '../database/connexion.php';

if (isset($_GET["id"])) {
    die("Erreur : ID du module non spécifié.");
}

$id = $_GET["id"];
$sql = "DELETE FROM modules WHERE codeModule = :id";

$statement = $pdo->prepare($sql);
$statement->execute([':id' => $id]);

header("Location: index.php");
exit();