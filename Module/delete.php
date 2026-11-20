<?php
require_once '../database/connexion.php';

if (!isset($_GET['id']) || $_GET['id'] === '') {
    die("Code du module manquant.");
}

$statement = $pdo->prepare("DELETE FROM modules WHERE codeModule = :id");
$statement->execute(['id' => $_GET['id']]);

header("Location: index.php");
exit;