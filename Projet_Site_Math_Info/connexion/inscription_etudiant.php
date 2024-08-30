<?php
require('../dbconnect.php');
session_start();

function generateRandomPassword($length = 6) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomPassword;
}

$randomPassword = generateRandomPassword();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_etu = isset($_POST['id_etu']) ? $_POST['id_etu'] : '';
    $nometudiant = isset($_POST['nometudiant']) ? $_POST['nometudiant'] : '';
    $prenometudiant = isset($_POST['prenometudiant']) ? $_POST['prenometudiant'] : '';
    $datenaissanceetu = isset($_POST['datenaissanceetu']) ? $_POST['datenaissanceetu'] : '';
    $lieunaissetu = isset($_POST['lieunaissetu']) ? $_POST['lieunaissetu'] : '';
    $mailetudiant = isset($_POST['mailetudiant']) ? $_POST['mailetudiant'] : '';
    $numeroetudiant = isset($_POST['numeroetudiant']) ? $_POST['numeroetudiant'] : '';
    $groupetd = isset($_POST['groupetd']) ? $_POST['groupetd'] : '';
    
    $id_etu = mysqli_real_escape_string($conn, $id_etu);
    $nometudiant = mysqli_real_escape_string($conn, $nometudiant);
    $prenometudiant = mysqli_real_escape_string($conn, $prenometudiant);
    $datenaissanceetu = mysqli_real_escape_string($conn, $datenaissanceetu);
    $lieunaissetu = mysqli_real_escape_string($conn, $lieunaissetu);
    $mailetudiant = mysqli_real_escape_string($conn, $mailetudiant);
    $numeroetudiant = mysqli_real_escape_string($conn, $numeroetudiant);
    $groupetd = mysqli_real_escape_string($conn, $groupetd);
    $niveau_user = 1;

    // Insertion dans la table des étudiants
    $sql = "INSERT INTO etudiants (ID_ETU, nometu, prenometu, datnaissetu, lieu_de_naissance, mailetu, numetu, grou_td, niveau_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $message2 = "Erreur de préparation de la requête : " . htmlspecialchars($conn->error);
    } else {
        $stmt->bind_param("ssssssssi", $id_etu, $nometudiant, $prenometudiant, $datenaissanceetu, $lieunaissetu, $mailetudiant, $numeroetudiant, $groupetd, $niveau_user);

        if ($stmt->execute()) {
            $message1 = "Etudiant enregistré avec succès.";
        } else {
            $message2 = "Erreur d'exécution de la requête : " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }

    // Insertion dans la table des utilisateurs
    $sql1 = "INSERT INTO utilisateur (matricule_user, nom_user, prenom_user, mp_user, niveau_user, mail_user) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1 === false) {
        $message2 = "Erreur de préparation de la requête : " . htmlspecialchars($conn->error);
    } else {
        $stmt1->bind_param("sssssi", $id_etu, $nometudiant, $prenometudiant, $randomPassword, $niveau_user, $mailetudiant);

        if ($stmt1->execute()) {
            $message1 = "Etudiant enregistré avec succès.";
            header('Location: inscription.php?id='.$id_etu);
        } else {
            $message2 = "Erreur d'exécution de la requête : " . htmlspecialchars($stmt1->error);
        }

        $stmt1->close();
    }

    $conn->close();
}
?>

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
    </style>

    <header>

        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>

        <a href="../index.html" class="list">Retour</a>

    </header>


    <div class="container">

        <h1>Inscription</h1>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-field">
                <input type="text" name="id_etu" require>
                <label for="id_etu">MATRICULE</label>
            </div>

            <div class="form-field">
                <input type="text" name="nometudiant" require>
                <label for="nometudiant">NOM</label>
            </div>

            <div class="form-field">
                <input type="text" name="prenometudiant" require>
                <label for="prenometudiant">PRENOM</label>
            </div>

            <div class="form-field">
                <input type="date" name="datenaissanceetu" require>
                <label for="datenaissanceetu">DATE DE NAISSANCE</label>
            </div>

            <div class="form-field">
                <input type="text" name="lieunaissetu" require>
                <label for="lieunaissetu">LIEU DE NAISSANCE</label>
            </div>

            <div class="form-field">
                <input type="email" name="mailetudiant" require>
                <label for="mailetudiant">EMAIL</label>
            </div>

            <div class="form-field">
                <input type="tel" name="numeroetudiant" require>
                <label for="numeroetudiant">NUMERO DE TELEPHONE</label>
            </div>

            <div class="form-field">
                <input type="text" name="groupetd" require>
                <label for="groupetd">GROUPE DE TD</label>
            </div>

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
