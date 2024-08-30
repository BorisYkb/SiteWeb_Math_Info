<?php
require('../dbconnect.php');
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idPV = mysqli_real_escape_string($conn, $_GET['id']);

    // Debug: Print the ID being used
    echo "Debug Info:<br>";
    echo "ID: " . $idPV . "<br>";

    // Requête pour obtenir le contenu du fichier
    $sql = "SELECT contenu FROM pv WHERE id_pv='$idPV'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Assurez-vous que les données sont présentes
        if ($row && !empty($row['contenu'])) {
            // Définir les en-têtes appropriés
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="document.png"'); // Définir un nom de fichier générique ou dynamique
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($row['contenu']));
            flush(); // Vider le tampon de sortie système
            echo $row['contenu']; // Envoyer le contenu du fichier
            exit;
        } else {
            echo "Fichier non trouvé dans la base de données pour l'ID : " . $idPV . "<br>";
        }
    } else {
        echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
    }
} else {
    echo "ID PV non spécifié.";
}
?>
