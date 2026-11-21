<?php
require_once '../database/connexion.php';

if (!isset($_GET['id']) || $_GET['id'] === '') {
    die("Code de la formation manquant.");
}

    $codeFormation = $_GET['id'];

    try {
        $statement = $pdo->prepare(
            "DELETE FROM formations WHERE codeFormation = :codeFormation"
        );
        $statement->execute(['codeFormation' => $codeFormation]);
    } catch (PDOException $e) {
        die("Impossible de supprimer cette formation : elle est utilisée par des étudiants ou des modules.");
    }

    header("Location: index.php");
    exit;