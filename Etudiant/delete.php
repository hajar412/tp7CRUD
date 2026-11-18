<?php
require_once '../database/connexion.php';

if (isset($_GET['id'])) {
    die("ID de l'étudiant manquant.");
}

$id = $_GET["id"];

$sql = "DELETE FROM etudiants WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $id]);

header("Location: index.php");
exit();