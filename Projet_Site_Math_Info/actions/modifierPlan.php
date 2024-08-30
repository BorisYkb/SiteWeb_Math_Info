<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <title>Modification d'informations</title>
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
      width: 450px;
      margin: 65px auto 0 auto;
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
      margin-top: 25px;
    }

    input {
      width: 100%;
      padding: 8px;
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

    .submit-button {
      text-align: center;
      width: 90%;
      padding: 10px;
      margin: 10px 0 0 20px;
      font-size: 16px;
      color: #fff;
      background-color: #08d80f;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .submit-button:hover{
    background-color: green;
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
    // Redirection vers la page d'administration
    header('Location: ../connexion.php');
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
        $message1 = 'Les données ont été modifiées avec succès.';
        // Rediriger vers une autre page après la modification
        header('Location: listePlan.php');
        exit;
    } else {
        $message2 = 'Erreur lors de la modification des données';
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>

  <div class="container">

    <h1>Modification infos planteur</h1>

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $idu; ?>" method="post">

      <div class="form-field">
        <input type="text" name="id" value="<?php echo $idu; ?>" required><br>
        <label for="id">ID</label>
      </div>

      <div class="form-field">
        <input type="text" name="nom" value="<?php echo $nomu; ?>" required><br>
        <label for="nom">Nom</label>
      </div>

      <div class="form-field">
        <input type="number" name="numero" value="<?php echo $numerou; ?>" required><br>
        <label for="numero">Numero</label>
      </div>

      <div class="form-field">
        <input type="email" name="mail" value="<?php echo $mailu; ?>" required><br>
        <label for="mail">Mail</label>
      </div>

      <div class="form-field">
        <input type="password" name="mp" value="<?php echo $mpu; ?>" required><br>
        <label for="mp">Mot de passe</label>
      </div>

      <div class="form-field">
        <input type="text" name="niveau" value="<?php echo $niveau; ?>" required><br>
        <label for="niveau">Niveau</label>
      </div>

      <div class="button-container">
        <input type="submit" value="Modifier" name="modifier" class="submit-button">
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
