<?php
// Connexion à la base de données
require('../dbconnect.php');
session_start();



// Requête pour recupérer les infos de l'enseignant
$sql0 = "SELECT * FROM enseignants WHERE id_enseignant ";
$resultatUSER = mysqli_query($conn, $sql0);
$USER = mysqli_fetch_assoc($resultatUSER);

$nomUSER = $USER['nom'];
$mailUSER = $USER['mail'];

// Requête pour compter le nombre de planteurs dans la table USER
$sql = "SELECT COUNT(matetu) AS total FROM etudiants";
$resultat = mysqli_query($conn, $sql);

if ($resultat) {
    $ligne = mysqli_fetch_assoc($resultat);
    $totaletudiant = $ligne['total'];
} else {
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
}


// Requête pour donner le nombre de cours enregistrés
$sql1 = "SELECT COUNT(id_enseignant) AS total FROM enseignants";
$resultat = mysqli_query($conn, $sql1);

if ($resultat) {
    $ligne = mysqli_fetch_assoc($resultat);
    $totalenseignant = $ligne['total'];
} else {
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
}

// Requête pour compter le nombre article
$sql = "SELECT COUNT(id_doc) AS total FROM documents";
$resultat = mysqli_query($conn, $sql);

if ($resultat) {
    $ligne = mysqli_fetch_assoc($resultat);
    $totalarticle = $ligne['total'];
} else {
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Doyen | MI</title>
</head>

<body>


    <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700");

    * {
        margin: 0;
        padding: 0;
        outline: none;
        border: none;
        text-decoration: none;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }


    body {
        background-color: #e1e1e1;
    }

    header {
        position: absolute;
        width: 100%;
        height: 60px;
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
        width: 150px;
        height: 50px;
        padding: 0 40px 0 30px;
        margin-left: 20px;
    }



    .list {
        font-size: 20;
        font-weight: bold;
        margin-left: 40px;
        color: black;
    }

    .list:hover {
        color: #0795c8d5;
    }



    .contener {
        position: absolute;
        display: flex;
        margin: 33px 0px 0px 0px;
    }


    nav {
        position: relative;
        top: 0;
        left: 0;
        bottom: 0;
        height: 100vh;
        background: #fff;
        width: 280px;
        overflow: hidden;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
    }

    nav li a {
        display: flex;
        flex-direction: column;
    }

    nav img {
        height: 100px;
        width: 100px;
        margin: 60px 0px 0px 95px;
        border-radius: 50%;
    }


    .logo1 {
        display: flex;
        flex-direction: column;
        text-align: center;
        margin-bottom: 30px;
    }

    .logo1 {
        color: black;
    }

    .logo1 h3 {
        font-size: 25px
    }

    .logo1 span {
        color: #0795c8d5;
    }

    .logo1 p {
        color: #7C7C7C;
        font-size: 11px;
    }


    .element {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .element a {
        font-weight: bold;
        position: relative;
        color: rgb(85, 83, 83);
        font-size: 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 230px;
        padding: 3px;
    }

    .element a:hover {
        background: #eee;
        border-radius: 10px;
    }

    .element h3 span {
        color: #0795c8d5;
    }



    .entete {
        display: flex;
        align-items: center;
    }

    .contener .element {
        margin: 10px;
    }

    .element h3 {
        margin-left: 5px;
    }



    .logout {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 10px;
        color: black;
    }

    .logout a div {
        display: flex;
        align-items: center;
        color: black;
    }


    .section1 form {
        margin: 30Px 0 30px 280px;
        display: flex;
        align-items: center;
    }

    .section1 span {
        color: #0795c8d5;
    }

    .search-input {
        padding: 5px 200px 5px 5px;
        font-size: 15px;
        margin-right: 5px;
        border: 2px solid #7C7C7C;
        border-radius: 3px;
    }

    .search-button button {
        background-color: transparent;
        color: black;
        font-size: 30px;
        cursor: pointer;
        transition: .5s;
    }

    .search-button {
        margin-top: 5px;
    }

    .search-button button:hover {
        color: #0795c8d5;
    }


    .start {
        display: flex;
        margin-top: 20px;
        margin-left: 70px;
    }

    .start .card {
        width: 50%;
        margin-right: 20px;
        background: #fff;
        text-align: center;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
    }

    .start .card h3 {
        margin: 10px;
        text-transform: capitalize;
    }

    .start .card p {
        font-size: 12px;
    }

    .start .card i {
        font-size: 22px;
        padding: 10px;
    }


    .section2 {
        margin-left: 37px;
        margin-bottom: 10px;
    }

    .recent h2 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .h3 {
        margin-left: 50px;
        margin-top: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.2);
        border: 2px solid transparent;
        border-radius: 5px;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 8px;
        padding-left: 30px;
        padding-right: 30px;

    }

    .footer {
        text-align: right;
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .footer a {
        padding: 5px 20px;
        background-color: #0795c8d5;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: .40s;
        border-radius: 5px;
    }

    .footer a:hover {
        background-color: green;
        color: white;
        border: 1px solid #0795c8d5;
    }
    </style>

    <header>

        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>

        <a href="../index.html" class="list">Accueil</a>

    </header>


    <div class="contener">


        <nav>
            <ul>

                <li>
                    <a href="#" class="logo1">
                        <img src="../images/equipe.jpg" alt="">
                        <h3 class="nav-item">Doyen <span><?php echo $nomUSER; ?></span></h3>
                        <p><?php echo $mailUSER; ?></p>
                    </a>
                </li>



                <li>
                    <div class="element">
                        <div class="entete">
                            <i class='bx bx-store-alt'></i>
                            <h3>Ac<span>tion</span></h3>
                        </div>
                        <div class="contenue">
                            <a href="../actions/liste_enseignant.php">
                                <span>Liste d'enseignants</span>
                            </a>
                            <a href="../actions/liste_etudiant.php">
                                <span>Liste d'étudiant</span>
                            </a>
                            <a href="../actions/liste_salle.php">
                                <span>Liste des Salles</span>
                            </a>
                            <a href="../actions/liste_secretaire.php">
                                <span>Liste des Secrétaire</span>
                            </a>
                            <a href="../actions/liste_article&memoire.php">
                                <span>Article et Mémoire</span>
                            </a>
                            <a href="../actions/liste_appareilleur.php">
                                <span>Liste des Appareilleurs</span>
                            </a>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="logout">
                        <a href="../../Web/Projet1.html">
                            <div>
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="nav-item">Logout</span>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <section class="section1">

            <div class="search">
                <form action="../actions/search.php" method="post">
                    <div class="">
                        <input type="text" name="search-input" placeholder="recherche" class="search-input" required>
                    </div>
                    <div class="search-button">
                        <button name="valider"><i class='bx bx-search-alt-2'></i></button>
                    </div>
                </form>
            </div>

            <div class="start">
                <div class="card">
                    <i class='bx bx-user'></i>
                    <h3><?php echo $totaletudiant; ?> <span>Etudiants</span></h3>
                    <p>dans la Classe</p>
                </div>
                <div class="card">
                    <i class='bx bxs-bank'></i>
                    <h3><?php echo $totalenseignant; ?><span> Enseignants</span></h3>
                    <p> enregistrés</p>
                </div>
                <div class="card">
                    <i class='bx bx-happy'></i>
                    <h3><?php echo $totalarticle; ?><span> Article et Mémoire</span></h3>
                    <p>enregistrés.</p>
                </div>
            </div>

            <section class="section2">

                <div class="recent">
                    <?php
                            require('../dbconnect.php');

                            // Récupérer les etudiants depuis la base de données
                            $sqlens = "SELECT * FROM etudiants ORDER BY matetu DESC LIMIT 4";
                            $resultatens = mysqli_query($conn, $sqlens);

                            if ($resultatens && mysqli_num_rows($resultatens) > 0) {
                                echo '<h3 class="h3">Liste de la <span>Classe</span></h3>';
                                echo '<table>';
                                echo '<thead><tr><th>Nom</th><th>Prenom</th><th>Date de Naissance</th><th>Email</th><th>Groupe TD</th></tr></thead>';
                                echo '<tbody>';

                                while ($row=$resultatens->fetch_assoc()) {
                                    $nometu = $row["nometu"];
                                    $prenometu = $row['prenometu'];
                                    $datenaiss = $row['datnaissetu'];
                                    
                                    $emailetu = $row['mailetu'];

                                    $grpetu = $row["grou_td"];

                                    echo '<tr><td>' . $nometu . '</td><td>' . $prenometu . '</td><td>' . $datenaiss . '</td><td>' . $emailetu . '</td><td>' . $grpetu . '</td></tr>';

                                }

                                echo '</tbody>';
                                echo '</table>';

                            } else {
                                echo '<p>Aucune production enregistrée.</p>';
                            }

                            mysqli_close($conn);
                        ?>

                </div>

                <div class="footer">
                    <a href="../actions/liste_etudiant.php">Plus</a>
                </div>

            </section>


        </section>


    </div>

</body>

</html>