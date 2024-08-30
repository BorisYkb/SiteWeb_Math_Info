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
    <title>Vérification</title>
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
      margin: 150px auto 0 auto;
      padding: 40px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
    }

    .form-field {
      position: relative;
      margin-bottom: 10px;
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

    .submit-button {
      text-align: center;
      width: 90%;
      padding: 10px;
      margin: 10px 0 0 30px;
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
  .errorMessage{
    margin: 10px 0 10px 90px;
    color: red;

  }
  </style>

    <header>

      <a href="../../Web/Projet1.html" class="logo">Korhogo<span>Cashew</span></a>

      <a href="../Admin/admin.php" class="list">Accueil</a>

    </header>
<?php
  require('../dbconnect.php');
  session_start();


  if ($_SERVER["REQUEST_METHOD"] == "POST"){

     // Échapper les caractères spéciaux pour éviter les attaques par injection SQL
      $iduser = mysqli_real_escape_string($conn, $_POST['iduser']);

     // Exécuter une requête SQL pour vérifier les informations saisies
      $sql = "SELECT * FROM USER WHERE ID_USER='$iduser'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Informations correctes, redirection vers la page de modification
        $row = $result->fetch_assoc();
        $id = $row['ID_USER'];
        $_SESSION['id_u_sup'] = $iduser;
        header('Location: supprimerPlan.php?id='.$id);
            exit();
        } else{
        $erreur = "L'identifiant est incorrect.";
       }
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>

  <div class="container">
    <h1>Vérification</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <div class="form-field">
        <input type="text" name="iduser" require>
        <label for="iduser">ID DU PLANTEUR</label>
      </div>

      <div class="button-container">
        <input type="submit" value="valider" name="valiser" class="submit-button">
      </div>

      <?php if (isset($erreur)) { ?>
        <p class="errorMessage"><?php echo $erreur; ?></p>
      <?php } ?>

    </form>

  </div>

</body>

</html>