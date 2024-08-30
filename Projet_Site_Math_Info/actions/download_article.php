<?php
require('../dbconnect.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT titre, contenu FROM documents WHERE id_doc = ?";
    $stmt = $conn->prepare($sql);

    
    

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($titre, $contenu);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"" . htmlspecialchars($titre) . ".pdf\"");
        echo $contenu;
    } else {
        echo "Fichier non trouvé.";
    }

    $stmt->close();
} else {
    echo "ID de fichier non fourni.";
}

$conn->close();
?>