<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de planteur</title>
</head>
<body>

    <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700");
    *{
      margin: 0;
      padding: 0;
      text-decoration: none;
    }


    body{
      height: 100vh;
      overflow: hidden;
      background-color: #f1f1f1;
      font-family: Arial, sans-serif;
    }

    header{
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

    .logo{
      font-size: 1.3rem;
      font-weight: 600;
      color: black;
      margin-left: 30px;
      padding: 0 40px 0 30px;
    }

    .logo span{
      color: #08d80f;
    }

    .list{
      font-size: 20;
      font-weight: bold;
      margin-left: 40px;
      color: black;
    }

    .list:hover{
      color: #08d80f;
    }

    .container {
      width: 400px;
      margin: 65px auto 0 auto;
      padding: 15px 40px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-field {
      position: relative;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    label {
      position: absolute;
      top: 50%;
      left: 10px;
      transform: translateY(-50%);
      font-size: 16px;
      font-weight: bold;
      color: black;
      transition: all 0.2s ease-in-out;
      pointer-events: none;
    }

    input:focus ~ label,
    input:valid ~ label {
      top: -10px;
      font-size: 12px;
      color: black;
    }

    .reset-button {
      text-align: center;
      width: 90%;
      padding: 10px;
      margin: 10px 0 0 30px;
      font-size: 16px;
      color: #fff;
      background-color: red;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .reset-button:hover{
    background-color: #800000;
  }
    </style>

    <header>

        <a href="../../Web/Projet1.html" class="logo">Korhogo<span>Cashew</span></a>

        <div class="bx bx-menu" id="menu"></div>

        <a href="../Admin/admin.php" class="list">Accueil</a>

    </header>

<?php
// Connexion à la base de données
require('../dbconnect.php');
session_start();

// Vérifier si un identifiant a été transmis dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'identifiant de la ligne à modifier/supprimer
    $idu = $_GET['id'];

    // Récupérer les informations de la ligne depuis la base de données
    $sql = "SELECT * FROM USER WHERE ID_USER = $idu";
    $resultat = mysqli_query($conn, $sql);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $ligne = mysqli_fetch_assoc($resultat);
        $idu = $ligne['ID_USER'];
        $nomu = $ligne['NOM_USER'];
        $numerou = $ligne['NUM_USER'];
        $mailu = $ligne['MAIL_USER'];
        $mpu = $ligne['MP_USER'];
        $niveau = $ligne['NIVEAU'];
    } else {
        echo 'Aucune ligne correspondante trouvée dans la base de données.';
        exit;
    }
} else {
    echo 'Aucun identifiant de ligne spécifié.';
    exit;
}

// Vérifier si la suppression a été demandée
if (isset($_POST['supprimer'])) {
    // Supprimer la ligne de la base de données
    $sql = "DELETE FROM USER WHERE ID_USER = $idu";
    $sql1 = "DELETE FROM PRODUCTION WHERE ID_USER = $idu";
    $resultat = mysqli_query($conn, $sql);
    $resultat1 = mysqli_query($conn, $sql1);

    if ($resultat && $resultat1) {
        $message1 = 'La ligne a été supprimée avec succès.';
        // Rediriger vers une autre page après la suppression
        header('Location: listePlan.php');
        exit;
    } else {
        $message2 = 'Erreur lors de la suppression des informations';
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>

   <div class="container">

      <h1>Suppression</h1>

      <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $idu; ?>" method="post">

            <div class="form-field">
            <input type="text" name="id" value="<?php echo $idu; ?>" required>
                <label for="id">ID</label>
            </div>

            <div class="form-field">
            <input type="text" name="nom" value="<?php echo $nomu; ?>" required>
                <label for="nom">NOM</label>
            </div>

            <div class="form-field">
            <input type="number" name="numero" value="<?php echo $numerou; ?>" required><br>
                <label for="numero">NUMERO</label>
            </div>

            <div class="form-field">
            <input type="email" name="mail" value="<?php echo $mailu; ?>" required>
                <label for="mail">MAIL</label>
            </div>

            <div class="form-field">
            <input type="password" name="mp" value="<?php echo $mpu; ?>" required>
                <label for="mp">MOT DE PASSE</label>
            </div>

            <div class="form-field">
            <input type="text" name="niveau" value="<?php echo $niveau; ?>" required>
                <label for="niveau">NIVEAU</label>
            </div>

            <div class="button-container">
                <input type="submit" value="Supprimer" name="supprimer" class="reset-button">
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
