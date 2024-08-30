<?php
require('../dbconnect.php');

$message1 = $message2 = "";

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
            $date_d = isset($_POST['date_d']) ? $_POST['date_d'] : '';
            $date_f = isset($_POST['date_f']) ? $_POST['date_f'] : '';
            $id_filiere = isset($_POST['id_filiere']) ? $_POST['id_filiere'] : '';
            $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : '';
            $annee_u = isset($_POST['annee_u']) ? $_POST['annee_u'] : '';
            
            // Préparer et exécuter la requête d'insertion
            $sql = "INSERT INTO emplois_du_temps (date_debut, date_fin, id_filiere, niveau, annee_uni, contenu) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $message2 = "Erreur de préparation de la requête : " . htmlspecialchars($conn->error);
            } else {
                $stmt->bind_param("ssssss", $date_d, $date_f, $id_filiere, $niveau, $annee_u, $fileContent);

                if ($stmt->execute()) {
                    $message1 = "Emploi du temps enregistré avec succès.";
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
    <title>Enregistrement d'emploi du temps</title>
    <link rel="icon" href="../images/logo_ufr_MI-transparent.png">
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
            height: 40px;
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
            width: 80px;
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
            margin: 70px auto 0 auto;
            padding: 15px 40px;
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
            padding: 7px;
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
            margin: 5px 95px;
            color: #0795c8d5;
            height: 100%;
            font-weight: bold;
        }

        .message2 {
            margin: 5px 50px;
            color: red;
            height: 100%;
            font-weight: bold;
        }

        .info{
            font-size: small;
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
        <h1>Enregistrement d'emploi du temps</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-field">
                <input type="date" name="date_d" require>
                <label for="date_d">Date de début</label>
            </div>

            <div class="form-field">
                <input type="date" name="date_f" require>
                <label for="date_f">Date de fin</label>
            </div>

            <div class="form-field">
                <input type="number" name="id_filiere" require>
                <label for="id_filiere">ID Filière</label>
            </div>

            <div class="form-field">
                <input type="text" name="niveau" require>
                <label for="niveau">Niveau d'étude</label>
            </div>

            <div class="form-field">
                <input type="number" name="annee_u" require>
                <label for="annee_u">Année universitaire</label>
            </div>

            <div class="form-field">
                <input type="file" name="contenu" accept=".xlsx" require>
                <label for="contenu">Contenu</label>
            </div>

            <p class="info">  * 2222: Informatique, 1111: Mathematique, 3333: Mécanique *</p>

            <div class="submit_box">
                <input type="submit" value="Enregistrer" name="submit" class="submit-button">
            </div>

            <?php if (!empty($message1)) { ?>
            <p class="message1"><?php echo $message1; ?></p>
            <?php } ?>
            <?php if (!empty($message2)) { ?>
            <p class="message2"><?php echo $message2; ?></p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
