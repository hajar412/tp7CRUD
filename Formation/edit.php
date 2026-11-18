<?php
require_once '../database/connexion.php';

if (isset($_GET["id"]))
    {
        die("Erreur : ID de la formation non spécifié.");
    }

    $id = $_GET["id"];
    $sql = "DELETE FROM formations WHERE codeFormation = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $id]);

    header("Location: index.php");
    exit();