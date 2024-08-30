<?php
require('../dbconnect.php');

$message1 = $message2 = "";

// Vérifier que l'ID est bien passé en paramètre et qu'il n'est pas vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idUSER = mysqli_real_escape_string($conn, $_GET['id']);
} else {
    // Afficher un message d'erreur et arrêter le script si l'ID est manquant
    echo "ID manquant ou invalide. Veuillez retourner à la page précédente.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['contenu']) && $_FILES['contenu']['error'] == UPLOAD_ERR_OK) {
        // Informations du fichier téléchargé
        $fileName = $_FILES['contenu']['name'];
        $fileType = $_FILES['contenu']['type'];
        $fileContent = file_get_contents($_FILES['contenu']['tmp_name']);
        
        // Vérifiez si le fichier a bien été lu
        if ($fileContent === false) {
            $message2 = "Erreur lors de la lecture du fichier.";
        } else {
            // Informations du formulaire
            $typef = isset($_POST['typef']) ? $_POST['typef'] : '';
            $titre = isset($_POST['titre']) ? $_POST['titre'] : '';
            $intitule = isset($_POST['intitule']) ? $_POST['intitule'] : '';
            $matiere = isset($_POST['matiere']) ? $_POST['matiere'] : '';
            $id_enseignant = isset($_POST['id_enseignant']) ? $_POST['id_enseignant'] : '';
            $id_filiere = isset($_POST['id_filiere']) ? $_POST['id_filiere'] : '';
            $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : '';

            // Préparer et exécuter la requête d'insertion
            $sql = "INSERT INTO cours_td (typef, titre, intitule, contenu, matiere, id_enseignant, id_filiere, niveau) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $message2 = "Erreur de préparation de la requête : " . htmlspecialchars($conn->error);
            } else {
                $stmt->bind_param("ssssssis", $typef, $titre, $intitule, $fileContent, $matiere, $id_enseignant, $id_filiere, $niveau);

                if ($stmt->execute()) {
                    $message1 = "Cours ou TD enregistré avec succès.";
                } else {
                    $message2 = "Erreur d'exécution de la requête : " . htmlspecialchars($stmt->error);
                }

                $stmt->close();
            }
        }
    } else {
        $message2 = "Erreur lors du téléchargement du fichier : " . $_FILES['contenu']['error'];
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo_ufr_MI-transparent.png">
    <title>Enregistrement Cours et TD</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700");

        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        body {
            height: 100vh;
            overflow: hidden;
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        header {
            position: absolute;
            width: 100%;
            height: 30px;
            right: 0;
            top: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            background: white;
            padding: 10px 3%;
            box-shadow: 0px 5px 10px -5px rgba(0, 0, 0, 0.5);
        }

        .logo img {
            width: 60px;
            height: 50px;
            padding: 0 40px 0 30px;
            margin-left: 30px;
        }

        .list {
            font-size: 20px;
            font-weight: bold;
            margin-left: 40px;
            color: black;
        }

        .list:hover {
            color: #0795c8d5;
        }

        .container {
            width: 450px;
            margin: 55px auto 0 auto;
            padding: 13px 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
        }

        .form-field {
            position: relative;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 14px;
            font-weight: bold;
            color: black;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
        }

        input:focus~label,
        input:valid~label,
        select:focus~label {
            top: -10px;
            font-size: 12px;
            color: black;
        }

        .submit-button {
            text-align: center;
            width: 90%;
            padding: 5px;
            margin: 3px 0 0 13px;
            font-size: 16px;
            color: #fff;
            margin-left: 30px;
            background-color: #0795c8d5;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #0550B2;
        }

        .message1 {
            padding: 5px 95px;
            color: #0795c8d5;
            height: 100%;
            font-size: 11px;
            font-weight: bold;
        }

        .message2 {
            margin: 5px 50px;
            color: red;
            height: 100%;
            font-weight: bold;
            font-size: 11px;
            
        }

        .info {
            font-size: 10px;
            margin: 5px;
            padding-left: 30px;
        }

    </style>
</head>

<body>
    <header>
        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>
        <a href="../index.html" class="list">Retour</a>
    </header>

    <div class="container">
        <h1>Enregistrement Cours et TD</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $idUSER; ?>" method="post" enctype="multipart/form-data">
            <div class="form-field">
                <select name="typef" require>
                    <option value="">Sélectionnez le type</option>
                    <option value="cours">Cours</option>
                    <option value="td">TD</option>
                </select>
                <label for="typef">Type</label>
            </div>

            <div class="form-field">
                <input type="text" name="titre" require>
                <label for="titre">Titre</label>
            </div>

            <div class="form-field">
                <input type="text" name="intitule" require>
                <label for="intitule">Intitulé</label>
            </div>

            <div class="form-field">
                <input type="text" name="matiere" require>
                <label for="matiere">Matière</label>
            </div>

            <div class="form-field">
                <input type="number" name="id_enseignant" value="<?php echo htmlspecialchars($idUSER); ?>" required>
                <label for="id_enseignant">ID Enseignant</label>
            </div>

            <div class="form-field">
                <input type="number" name="id_filiere" require>
                <label for="id_filiere">ID Filière</label>
            </div>

            <div class="form-field">
                <input type="text" name="niveau" require>
                <label for="niveau">Niveau</label>
            </div>

            <div class="form-field">
                <input type="file" name="contenu" accept=".pdf" require>
                <label for="contenu">Contenu</label>
            </div>

            <p class="info">* 2222: Informatique, 1111: Mathematique, 3333: Mécanique *</p>

            <?php if (!empty($message1)) { ?>
            <p class="message1"><?php echo htmlspecialchars($message1); ?></p>
            <?php } ?>
            <?php if (!empty($message2)) { ?>
            <p class="message2"><?php echo htmlspecialchars($message2); ?></p>
            <?php } ?>

            <div class="submit_box">
                <input type="submit" value="Enregistrer" name="submit" class="submit-button">
            </div>

        </form>
    </div>
</body>
</html>
