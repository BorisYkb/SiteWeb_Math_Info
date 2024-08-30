<?php
require('../dbconnect.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT date_debut, niveau, contenu FROM emplois_du_temps WHERE cod_edt = ?";
    $stmt = $conn->prepare($sql);

    
    

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($date, $niveau, $contenu);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"" . htmlspecialchars($date) ."_".htmlspecialchars($niveau). ".xlsx\"");
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