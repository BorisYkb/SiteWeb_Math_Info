<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détale planteur</title>
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
  font-family: 'Poppins', Arial, sans-serif;
}

header {
  position: absolute;
  width: 100%;
  height: 20px;
  right: 0;
  top: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  background: white;
  padding: 10px 3%;
  box-shadow: 0px 5px 10px -5px rgba(0, 0, 0, 0.5);
}

.logo {
  font-size: 1.3rem;
  font-weight: 600;
  color: black;
  margin-left: 30px;
  padding: 0 40px 0 30px;
}

.logo span {
  color: #08d80f;
}

.list {
  font-size: 17px;
  font-weight: bold;
  margin-left: 40px;
  color: black;
}

.list:hover {
  color: #08d80f;
}

.container {
  max-width: 400px;
  margin: 65px auto 0 auto;
  padding: 5px 50px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 24px;
  font-weight: 600;
  text-align: center;
  margin-bottom: 5px;
}

.form-group {
  margin-bottom: 10px;
}

label {
  display: block;
  font-size: 13px;
  font-weight: bold;
  color: #333;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"] {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.button-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 5px;
}

.submit-button,
.reset-button {
  width: 48%;
  padding: 9px;
  font-size: 16px;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.submit-button {
    background-color: #08d80f;
}

.reset-button {
    background-color: red;
}

.submit-button:hover{
  background-color: #047a0a;
}

.reset-button:hover {
  background-color: #800000;
}

.message1{
  margin: 5px 95px;
  color: #08d80f;
  height: 100%;
}

.message2{
  margin: 5px 95px;
  color: red;
  height: 100%;
}

</style>
   

  <header>

    <a href="../../Web/Projet1.html" class="logo">Korhogo<span>Cashew</span></a>

    <a href="../Admin/admin.php" class="list">Accueil</a>

  </header>

<?php
// Connexion à la base de données
require('../dbconnect.php');
session_start();

// Vérifier si un identifiant a été transmis dans l'URL
if (isset($_GET['iduser'])) {
    // Récupérer l'identifiant de la ligne à modifier/supprimer
    $idu = $_GET['iduser'];

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

// Vérifier si le formulaire a été soumis pour effectuer la modification
if (isset($_POST['modifier'])) {
    // Récupérer les nouvelles valeurs du formulaire
    $nouveauid = $_POST['id'];
    $nouveauNom = $_POST['nom'];
    $nouveauNumero = $_POST['numero'];
    $nouveauMail = $_POST['mail'];
    $nouveauMp = $_POST['mp'];
    $nouveauNiveau = $_POST['niveau'];

    // Effectuer la mise à jour des données dans la base de données
    $sql = "UPDATE USER SET ID_USER = '$nouveauid', NOM_USER = '$nouveauNom', NUM_USER = '$nouveauNumero', MAIL_USER = '$nouveauMail', MP_USER = '$nouveauMp', NIVEAU = '$nouveauNiveau' WHERE ID_USER = $idu";
    $resultat = mysqli_query($conn, $sql);

    if ($resultat) {
        $messageM1 = 'Les données ont été modifiées avec succès.';
        // Rediriger vers une autre page après la modification
        header('Location: listePlan.php');
        exit;
    } else {
        $messageM2 = 'Erreur lors de la modification des données';
    }
}

// Vérifier si la suppression a été demandée
if (isset($_POST['supprimer'])) {
    // Supprimer la ligne de la base de données
    $sql = "DELETE FROM USER WHERE ID_USER = $idu";
    $sql1 = "DELETE FROM PRODUCTION WHERE ID_USER = $idu";
    $resultat = mysqli_query($conn, $sql);
    $resultat1 = mysqli_query($conn, $sql1);

    if ($resultat && $resultat1) {
        $messageS1 = 'La ligne a été supprimée avec succès.';
        // Rediriger vers une autre page après la suppression
        header('Location: listePlan.php');
        exit;
    } else {
        $messageS2 = 'Erreur lors de la suppression des données' ;
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>

    <div class="container">

        <h1>Détail</h1>

        <form action="<?php echo $_SERVER['PHP_SELF'] . '?iduser=' . $idu; ?>" method="post">

            <div class="form-group">
                <input type="text" name="id" value="<?php echo $idu; ?>" required>
                <label for="id">ID</label>
            </div>

            <div class="form-group">
                <input type="text" name="nom" value="<?php echo $nomu; ?>" required>
                <label for="nom">NOM</label>
            </div>

            <div class="form-group">
                <input type="number" name="numero" value="<?php echo $numerou; ?>" required>
                <label for="numero">NUMERO</label>
            </div>

            <div class="form-group">
                <input type="email" name="mail" value="<?php echo $mailu; ?>" required>
                <label for="mail">MAIL</label>
            </div>

            <div class="form-group">
                <input type="password" name="mp" value="<?php echo $mpu; ?>" required>
                <label for="mp">MOT DE PASSE</label>
            </div>

            <div class="form-group">
                <input type="text" name="niveau" value="<?php echo $niveau; ?>" required>
                <label for="niveau">NIVEAU</label>
            </div>

            <div class="button-container">
                <input type="submit" value="Modifier" name="modifier" class="submit-button">
                <input type="submit" value="Supprimer" name="supprimer" class="reset-button">
            </div>

            <?php if (isset($messageM1)) { ?>
                <p class="message1"><?php echo $messageM1; ?></p>
            <?php } ?>
            <?php if (isset($messageM2)) { ?>
                <p class="message2"><?php echo $messageM2; ?></p>
            <?php } ?>

            <?php if (isset($messageS1)) { ?>
                <p class="message1"><?php echo $messageS1; ?></p>
            <?php } ?>
            <?php if (isset($messageS2)) { ?>
                <p class="message2"><?php echo $messageS2; ?></p>
            <?php } ?>

        </form>

    </div>

</body>


</html>
