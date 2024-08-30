<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../images/logo_ufr_MI-transparent.png">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Inscription Etudiant | MI</title>
</head>

<body>

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

    input {
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

    <header>
        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>
        <a href="../index.html" class="list">Retour</a>
    </header>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('../dbconnect.php');
    session_start();

    // Vérifier que l'ID est bien passé en paramètre et qu'il n'est pas vide
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id_etu = mysqli_real_escape_string($conn, $_GET['id']);

        // Vérifier si le formulaire est soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $date_in = isset($_POST['date_inscription']) ? $_POST['date_inscription'] : '';
            $id_filiere = isset($_POST['id_filiere']) ? $_POST['id_filiere'] : '';
            $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : '';
            $specialite = isset($_POST['specialite']) ? $_POST['specialite'] : '';

            // Échapper les caractères spéciaux pour éviter les attaques par injection SQL
            $date_in = mysqli_real_escape_string($conn, $date_in);
            $id_filiere = mysqli_real_escape_string($conn, $id_filiere);
            $niveau = mysqli_real_escape_string($conn, $niveau);
            $specialite = mysqli_real_escape_string($conn, $specialite);

            // Exécuter la requête d'insertion
            $sql = "INSERT INTO inscriptions (date_i, id_etudiant, id_filiere, niveau, specialite) VALUES ('$date_in', '$id_etu', '$id_filiere', '$niveau', '$specialite')";
            if ($conn->query($sql) === TRUE) {
                $message1 = "Étudiant enregistré avec succès.";
            } else {
                $message2 = "Erreur d'enregistrement : " . $conn->error;
            }
        }
    } else {
        // Gestion du cas où l'ID n'est pas passé ou est vide
        echo "ID étudiant non spécifié.";
        exit;
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
    ?>

    <div class="container">
        <h1>Inscription</h1>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . htmlspecialchars($_GET['id']); ?>" method="post">
            <div class="form-field">
                <input type="date" name="date_inscription" required>
                <label for="date_inscription">Date d'inscription</label>
            </div>

            <div class="form-field">
                <input type="number" name="id_filiere" required>
                <label for="id_filiere">ID de la filière</label>
            </div>
            

            <div class="form-field">
                <input type="text" name="niveau" required>
                <label for="niveau">Niveau d'étude</label>
            </div>

            <div class="form-field">
                <input type="text" name="specialite" required>
                <label for="specialite">Specialité</label>
            </div>

            <p class="info">  * 2222: Informatique, 1111: Mathematique, 3333: Mécanique *</p>

            <div class="submit_box">
                <input type="submit" value="Enregistrer" name="submit" class="submit-button">
            </div>

            <?php if (isset($message1)) { ?>
            <p class="message1"><?php echo $message1; ?></p>
            <?php } ?>
            <?php if (isset($message2)) { ?>
            <p class="message2"><?php echo $message2; ?></p>
            <?php } ?>
        </form>
    </div>

</body>
</html>
