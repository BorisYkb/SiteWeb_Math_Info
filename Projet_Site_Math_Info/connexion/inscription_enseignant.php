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
    <title>Inscription</title>
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
        width: 70px;
        height: 40px;
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
        padding: 10px 40px 15px 40px;
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
        padding: 6px;
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

    <header>

        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>

        <a href="resp_filiere.php" class="list">Retour</a>

    </header>
</head>

<body>
    <?php
        require('../dbconnect.php');
        session_start();

        $message1 = "";
        $message2 = "";

        // Fonction pour générer un mot de passe aléatoire
        function generateRandomPassword($length = 8) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        // Vérifier si le formulaire est soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier la présence des clés dans $_POST
            if (
                isset($_POST['idenseignant']) && isset($_POST['nomenseignant']) && isset($_POST['prenomenseignant']) &&
                isset($_POST['mailenseignant']) && isset($_POST['numeroenseignant']) && isset($_POST['departement']) &&
                isset($_POST['specialite']) && isset($_POST['code']) && isset($_POST['niveauenseignant']) && isset($_POST['matsecretaire'])
            ) {
                $idenseignant = $_POST['idenseignant'];
                $nomenseignant = $_POST['nomenseignant'];
                $prenomenseignant = $_POST['prenomenseignant'];
                $mailenseignant = $_POST['mailenseignant'];
                $numeroenseignant = $_POST['numeroenseignant'];
                $departement = $_POST['departement'];
                $specialite = $_POST['specialite'];
                $code = $_POST['code'];
                $niveauenseignant = $_POST['niveauenseignant'];
                $matsecretaire = $_POST['matsecretaire'];

                // Échapper les caractères spéciaux pour éviter les attaques par injection SQL
                $idenseignant = mysqli_real_escape_string($conn, $idenseignant);
                $nomenseignant = mysqli_real_escape_string($conn, $nomenseignant);
                $prenomenseignant = mysqli_real_escape_string($conn, $prenomenseignant);
                $mailenseignant = mysqli_real_escape_string($conn, $mailenseignant);
                $numeroenseignant = mysqli_real_escape_string($conn, $numeroenseignant);
                $departement = mysqli_real_escape_string($conn, $departement);
                $specialite = mysqli_real_escape_string($conn, $specialite);
                $code = mysqli_real_escape_string($conn, $code);
                $niveauenseignant = mysqli_real_escape_string($conn, $niveauenseignant);
                $matsecretaire = mysqli_real_escape_string($conn, $matsecretaire);

                // Générer un mot de passe aléatoire
                $password = generateRandomPassword();

                // Commencer une transaction
                $conn->begin_transaction();

                try {
                    // Exécuter la requête d'insertion dans la table enseignants
                    $sql = "INSERT INTO enseignants (id_enseignant, nom, prenom, mail, telephone, departement, specialite, cod_edt, mat_secretaire, niveau_user) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt === false) {
                        throw new Exception("Erreur de préparation de la requête enseignants: " . htmlspecialchars($conn->error));
                    } else {
                        $stmt->bind_param("issssssssi", $idenseignant, $nomenseignant, $prenomenseignant, $mailenseignant, $numeroenseignant, $departement, $specialite, $code, $matsecretaire, $niveauenseignant);

                        if (!$stmt->execute()) {
                            throw new Exception("Erreur d'exécution de la requête enseignants: " . htmlspecialchars($stmt->error));
                        }

                        // Fermer la déclaration
                        $stmt->close();
                    }

                    // Exécuter la requête d'insertion dans la table utilisateur
                    $sql = "INSERT INTO utilisateur (id_user, matricule_user, nom_user, prenom_user, mp_user, niveau_user, mail_user) VALUES (?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt === false) {
                        throw new Exception("Erreur de préparation de la requête utilisateur: " . htmlspecialchars($conn->error));
                    } else {
                        $stmt->bind_param("issssis", $idenseignant, $idenseignant, $nomenseignant, $prenomenseignant, $password, $niveauenseignant, $mailenseignant);

                        if (!$stmt->execute()) {
                            throw new Exception("Erreur d'exécution de la requête utilisateur: " . htmlspecialchars($stmt->error));
                        }

                        // Fermer la déclaration
                        $stmt->close();
                    }

                    // Valider la transaction
                    $conn->commit();
                    $message1 = "Enseignant enregistré avec succès.";
                } catch (Exception $e) {
                    // Annuler la transaction en cas d'erreur
                    $conn->rollback();
                    $message2 = $e->getMessage();
                }

                // Fermer la connexion à la base de données
                $conn->close();
            } else {
                $message2 = "Tous les champs du formulaire doivent être remplis.";
            }
        }
    ?>

    <div class="container">
        <h1>Inscription</h1>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-field">
                <input type="number" name="idenseignant" required>
                <label for="idenseignant">ID</label>
            </div>

            <div class="form-field">
                <input type="text" name="nomenseignant" required>
                <label for="nomenseignant">NOM</label>
            </div>

            <div class="form-field">
                <input type="text" name="prenomenseignant" required>
                <label for="prenomenseignant">PRENOM</label>
            </div>

            <div class="form-field">
                <input type="email" name="mailenseignant" required>
                <label for="mailenseignant">EMAIL</label>
            </div>

            <div class="form-field">
                <input type="tel" name="numeroenseignant" required>
                <label for="numeroenseignant">NUMERO DE TELEPHONE</label>
            </div>

            <div class="form-field">
                <input type="text" name="departement" required>
                <label for="departement">DEPARTEMENT</label>
            </div>

            <div class="form-field">
                <input type="text" name="specialite" required>
                <label for="specialite">SPECIALITE</label>
            </div>

            <div class="form-field">
                <input type="number" name="code" required>
                <label for="code">CODE EMPLOIE DU TEMPS</label>
            </div>

            <div class="form-field">
                <input type="number" name="niveauenseignant" required>
                <label for="niveauenseignant">NIVEAU</label>
            </div>

            <div class="form-field">
                <input type="number" name="matsecretaire" required>
                <label for="matsecretaire">MAT SECRETAIRE</label>
            </div>

            <?php if (!empty($message1)) { ?>
            <p class="message1"><?php echo $message1; ?></p>
            <?php } ?>
            <?php if (!empty($message2)) { ?>
            <p class="message2"><?php echo $message2; ?></p>
            <?php } ?>

            <div class="submit_box">
                <input type="submit" value="Enregistrer" name="submit" class="submit-button">
            </div>


        </form>
    </div>
</body>

</html>
