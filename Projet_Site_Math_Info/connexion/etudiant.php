<?php
// Connexion à la base de données
require('../dbconnect.php');
session_start();

// Initialiser les variables
$nomUSER = $mailUSER = $niveau_etude = $specialite = $totalcours = $totaletudiant = $totaledt = 0;

// Vérifier que l'ID est bien passé en paramètre et qu'il n'est pas vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idUSER = mysqli_real_escape_string($conn, $_GET['id']);

    // Requête pour récupérer les infos de l'étudiant
    $sql0 = "SELECT * FROM etudiants WHERE ID_ETU = '$idUSER'";
    $resultatUSER1 = mysqli_query($conn, $sql0);

    // Vérifier que la requête a renvoyé des résultats
    if ($resultatUSER1 && mysqli_num_rows($resultatUSER1) > 0) {
        $USER = mysqli_fetch_assoc($resultatUSER1);

        $nomUSER = htmlspecialchars($USER['nometu']);
        $mailUSER = htmlspecialchars($USER['mailetu']);
    } else {
        // Gestion du cas où aucun utilisateur n'a été trouvé
        echo "Aucun étudiant trouvé avec l'ID spécifié.";
        exit;
    }

    // Requête pour récupérer les infos d'inscription de l'étudiant
    $sql8 = "SELECT * FROM inscriptions WHERE id_etudiant = '$idUSER'";
    $resultatUSER = mysqli_query($conn, $sql8);
    
    // Vérifier que la requête a renvoyé des résultats
    if ($resultatUSER && mysqli_num_rows($resultatUSER) > 0) {
        $USER1 = mysqli_fetch_assoc($resultatUSER);
    
        $niveau_etude = htmlspecialchars($USER1['niveau']);
        $specialite = htmlspecialchars($USER1['specialite']);
    } else {
        // Gestion du cas où aucune inscription n'a été trouvée
        echo "Aucune inscription trouvée pour l'étudiant.";
        exit;
    }
}

// Requête pour compter le nombre de cours et TD de l'étudiant
$sql = "SELECT COUNT(id_ct) AS total FROM cours_td WHERE niveau = '$niveau_etude' AND specialite = '$specialite'";
$resultat = mysqli_query($conn, $sql);

if ($resultat) {
    $ligne = mysqli_fetch_assoc($resultat);
    $totalcours = $ligne['total'];
} else {
    echo "Erreur lors de l'exécution de la requête pour le nombre de cours et TD : " . mysqli_error($conn);
}

// Requête pour donner le nombre d'étudiants
$sql1 = "SELECT COUNT(ID_ETU) AS total FROM etudiants";
$resultat = mysqli_query($conn, $sql1);

if ($resultat) {
    $ligne = mysqli_fetch_assoc($resultat);
    $totaletudiant = $ligne['total'];
} else {
    echo "Erreur lors de l'exécution de la requête pour le nombre d'étudiants : " . mysqli_error($conn);
}

// Requête pour compter le nombre d'emplois du temps
$sql = "SELECT COUNT(cod_edt) AS total FROM emplois_du_temps";
$resultat = mysqli_query($conn, $sql);

if ($resultat) {
    $ligne = mysqli_fetch_assoc($resultat);
    $totaledt = $ligne['total'];
} else {
    echo "Erreur lors de l'exécution de la requête pour le nombre d'emplois du temps : " . mysqli_error($conn);
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
    <link rel="icon" href="../images/logo_ufr_MI-transparent.png">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Etudiant | MI</title>
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
        height: 50px;
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
        margin: 50px 0px 0px 95px;
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
        padding: 20px;
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
        padding-left: 20px;
        padding-right: 20px;

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
        background-color: #088DC6D5;
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
                        <h3 class="nav-item">Etudiant <span><?php echo $nomUSER; ?></span></h3>
                        <p><?php echo $mailUSER; ?></p>
                    </a>
                </li>



                <li>
                    <div class="element">
                        <div class="entete">
                            <i class='bx bx-store-alt'></i>
                            <h3>Tableau<span>de borde</span></h3>
                        </div>
                        <div class="contenue">

                            <a href="../actions/liste_etudiant.php?id=<?php echo $idUSER; ?>">
                                <span>Liste des Etudiants</span>
                            </a>
                            <a href="../actions/liste_cours&td.php?id=<?php echo $idUSER; ?>">
                                <span>Liste des Cours et TD</span>
                            </a>
                            <a href="demande.php?id=<?php echo $idUSER; ?>">
                                <span>Faire une Demande</span>
                            </a>
                            <a href="../actions/liste_emplois_du_temps.php?id=<?php echo $idUSER; ?>">
                                <span>Emplois du temps</span>
                            </a>

                            <a href="../actions/liste_note.php?id=<?php echo $idUSER; ?>">
                                <span>Voir Note</span>
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
                    <i class='bx bxs-bank'></i>
                    <h3><?php echo $totaletudiant; ?><span> Etudiants</span></h3>
                    <p> enregistrés</p>
                </div>
                <div class="card">
                    <i class='bx bx-happy'></i>
                    <h3><?php echo $totaledt; ?><span> Emplois du temps</span></h3>
                    <p>enregistrés.</p>
                </div>
                <div class="card">
                    <i class='bx bx-user'></i>
                    <h3><?php echo $totalcours; ?> <span>Cours et TD</span></h3>
                    <p>enregistrés</p>
                </div>
            </div>

            <section class="section2">

                <div class="recent">
                    <?php
                            require('../dbconnect.php');

                            // Récupérer les etudiants depuis la base de données
                            $sqlens = "SELECT * FROM cours_td ORDER BY typef DESC LIMIT 4";
                            $resultatens = mysqli_query($conn, $sqlens);

                            if ($resultatens && mysqli_num_rows($resultatens) > 0) {
                                echo '<h3 class="h3">Liste de <span>Cours & TD</span></h3>';
                                echo '<table>';
                                echo '<thead><tr><th>Type</th><th>Titre</th><th>Matière</th><th>Intitulé</th></tr></thead>';
                                echo '<tbody>';

                                while ($row=$resultatens->fetch_assoc()) {
                                    $typef = $row["typef"];
                                    $titre = $row['titre'];
                                    $matiere = $row['matiere'];
                                    
                                    $intitule = $row['intitule'];

                                    echo '<tr><td>' . $typef . '</td><td>' . $titre . '</td><td>' . $matiere . '</td><td>' . $intitule . '</td></tr>';

                                }

                                echo '</tbody>';
                                echo '</table>';

                            } else {
                                echo '<p>Aucune cours ou TD enregistrée.</p>';
                            }

                            mysqli_close($conn);
                        ?>

                </div>

                <div class="footer">
                    <a href="../actions/liste_cours&td.php">Plus</a>
                </div>

            </section>


        </section>


    </div>

</body>

</html>