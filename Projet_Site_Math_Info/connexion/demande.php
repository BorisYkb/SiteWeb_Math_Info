<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Article & Mémoire | MI</title>
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
        margin: 100px auto 0 auto;
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
        margin-bottom: 16px;
    }

    input {
        width: 100%;
        padding: 5px;
        font-size: 14px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    label {
        position: absolute;
        top: 50%;
        left: 10px;
        margin-top: 5px;
        transform: translateY(-50%);
        font-size: 14px;
        font-weight: bold;
        color: black;
        transition: all 0.2s ease-in-out;
        pointer-events: none;
    }

    textarea {
        width: 100%;
        padding: 5px;
        font-size: 14px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input:focus~label,
    input:valid~label {
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
        margin: 5px 70px;
        color: #0795c8d5;
        height: 100%;
    }

    .message2 {
        margin: 5px 70px;
        color: red;
        height: 100%;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <?php
        require('../dbconnect.php');
        session_start();

        $message1 = "";
        $message2 = "";

        // Vérifier si le formulaire est soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier la présence des clés dans $_POST
            if (
                isset($_POST['type']) &&
                isset($_POST['description']) &&
                isset($_POST['date']) &&
                isset($_POST['statut']) &&
                isset($_POST['id_enseignant']) &&
                isset($_POST['id_etudiant'])
            ) {
                $description = $_POST['description'];
                $type = $_POST['type'];
                $date = $_POST['date'];
                $statut = $_POST['statut'];
                $id_enseignant = $_POST['id_enseignant'];
                $id_etudiant = $_POST['id_etudiant'];

                // Échapper les caractères spéciaux pour éviter les attaques par injection SQL
                $description = mysqli_real_escape_string($conn, $description);
                $type = mysqli_real_escape_string($conn, $type);
                $date = mysqli_real_escape_string($conn, $date);
                $statut = mysqli_real_escape_string($conn, $statut);
                $id_enseignant = mysqli_real_escape_string($conn, $id_enseignant);
                $id_etudiant = mysqli_real_escape_string($conn, $id_etudiant);

                // Vérifier l'existence des id_enseignant et id_etudiant dans la base de données
                $queries = [
                    "SELECT id FROM enseignants WHERE id = '$id_enseignant'",
                    "SELECT matetu FROM etudiants WHERE matetu = '$id_etudiant'"
                ];
                $valid = true;

                foreach ($queries as $query) {
                    $result = $conn->query($query);
                    if ($result && $result->num_rows == 0) {
                        $valid = false;
                        break;
                    }
                }

                if ($valid) {
                    // Exécuter la requête d'insertion
                    $sql = "INSERT INTO demandes (description, type, date, statut, id_enseignant, id_etudiant) VALUES (?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt === false) {
                        $message2 = "Erreur de préparation de la requête : " . htmlspecialchars($conn->error);
                    } else {
                        $stmt->bind_param("sssisi", $description, $type, $date, $statut, $id_enseignant, $id_etudiant);

                        if ($stmt->execute()) {
                            $message1 = "Document enregistré avec succès.";
                        } else {
                            $message2 = "Erreur d'exécution de la requête : " . htmlspecialchars($stmt->error);
                        }

                        // Fermer la déclaration
                        $stmt->close();
                    }
                } else {
                    $message2 = "ID enseignant ou ID étudiant non valide.";
                }

                // Fermer la connexion à la base de données
                $conn->close();
            } else {
                $message2 = "Tous les champs du formulaire doivent être remplis.";
            }
        }
    ?>

    <header>
        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>
        <a href="../index.html" class="list">Accueil</a>
    </header>

    <div class="container">
        <h1>DEMANDE</h1>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-field">
                <input type="text" name="description">
                <label for="description">DESCRIPTION</label>
                <!--<textarea name="description" id="description" cols="30" rows="10" require></textarea>-->
            </div>

            <div class="form-field">
                <input type="text" name="type" require>
                <label for="type">TYPE</label>
            </div>

            <div class="form-field">
                <input type="date" name="date" require>
                <label for="date">DATE</label>
            </div>

            <div class="form-field">
                <input type="text" name="statut" require>
                <label for="statut">STATUT</label>
            </div>

            <div class="form-field">
                <input type="number" name="id_enseignant" require>
                <label for="id_enseignant">ID ENSEIGNANT</label>
            </div>

            <div class="form-field">
                <input type="number" name="id_etudiant" require>
                <label for="id_etudiant">ID ETUDIANT</label>
            </div>



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