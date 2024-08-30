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
    <link rel="icon" href="../images/logo_ufr_MI-transparent.png">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Connexion</title>
</head>

<body>
    <style>
    * {
        font-family: 'Poppins'sans serif;
    }

    body {
        background-image: url(../images/1.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    .box {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
    }

    form {
        width: 350px;
        display: flex;
        flex-direction: column;
        padding: 0 15 0 15px;
    }

    header {
        color: black;
        font-size: 30px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        padding: 10px 0 10px 0;
    }

    .input {
        display: flex;
        flex-direction: column;
    }

    .input1 {
        height: 45px;
        width: 87%;
        border: none;
        outline: none;
        border-radius: 30px;
        color: black;
        font-weight: bolder;
        padding: 0 0 0 45px;
        background: rgba(255, 255, 255, 0.7);
    }

    i {
        position: relative;
        top: -55px;
        left: 17px;
        color: black;
        font-size: 25px;
        font-weight: 700;
    }

    ::-webkit-input-placeholder {
        color: black;
        font-size: 15px;
        font-weight: bold;
    }

    .top-header1 {
        color: black;
        font-size: 20px;
    }

    .submit {
        border: none;
        border-radius: 30px;
        font-weight: bold;
        font-size: 15px;
        height: 45px;
        outline: none;
        width: 100%;
        background: rgba(255, 255, 255, 0.9);
        cursor: pointer;
        transition: .3s;
    }

    .submit:hover {
        background-color: rgba(255, 255, 255, 0.7);
        color: black;
        font-weight: bold;
    }

    .errorMessage {
        font-weight: bold;
    }
    </style>
    <?php
  require('..\dbconnect.php');
  session_start();
  


  if ($_SERVER["REQUEST_METHOD"] == "POST"){

     // Échapper les caractères spéciaux pour éviter les attaques par injection SQL
      $user = mysqli_real_escape_string($conn, $_POST['user']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $_SESSION['user'] = $user;

     // Exécuter une requête SQL pour vérifier les informations saisies
      $sql = "SELECT * FROM utilisateur WHERE (nom_user='$user' OR prenom_user = '$user' OR mail_user='$user' OR id_user='$user') AND mp_user='$password'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
       // Informations correctes, récupérer le niveau de l'utilisateur
        $row = $result->fetch_assoc();
        $niveau = $row['niveau_user'];
        $id = $row['id_user'];
        $id2 = $row['matricule_user'];
        $_SESSION['vali_connexion'] = $id;

       // Redirection en fonction du niveau
        if ($niveau == 1) {
            header('Location: etudiant.php?id='.$id2);
            exit();
        } elseif ($niveau == 2) {
            header('Location: enseignent.php?id='.$id);
            exit();
        } elseif ($niveau == 3) {
            header('Location: appareilleur.php?id='.$id);
            exit();
        } elseif ($niveau == 4) {
            header('Location: secretaire.php?id='.$id);
            exit();
        } elseif ($niveau == 5) {
            header('Location: resp_filiere.php?id='.$id);
            exit();
        } elseif ($niveau == 6) {
            header('Location: resp_exam.php?id='.$id);
            exit();
        } elseif ($niveau == 7) {
            header('Location: resp_parcour.php?id='.$id);
            exit();
        } elseif ($niveau == 8) {
            header('Location: doyen.php?id='.$id);
            exit();
        }
      } else{
        $erreur = "Le nom d'utilisateur ou le mot de passe est incorrect.";
       }
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>

    <div class="box">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="top-header">
                <header>Bienvenue</header>
            </div>
            <div class="top-header1">
                <?php if (isset($erreur)) { ?>
                <p class="errorMessage"><?php echo $erreur; ?></p>
                <?php } ?>
            </div>
            <div class="input">
                <input type="text" name="user" placeholder="Entrez votre nom ou votre mail" class="input1" required><br>
                <i class='bx bx-user'></i>
            </div>
            <div class="input">
                <input type="password" name="password" placeholder=" Entrez votre Mot de passe" class="input1"
                    required><br>
                <i class=" bx bx-lock-alt"></i>
            </div>
            <div class="input">
                <input type="submit" value="Connexion " name="submit" class="submit">
            </div>
        </form>

    </div>
</body>

</html>