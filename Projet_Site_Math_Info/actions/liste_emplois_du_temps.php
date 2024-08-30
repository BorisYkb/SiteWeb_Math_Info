<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des emplois du temps</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../images/logo_ufr_MI-transparent.png">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <?php 
        // Connexion à la base de donnée et ouverture d'une session
        require('../dbconnect.php');
        session_start();
    ?>


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

    .contenue {
        margin-top: 70px;
    }

    .contenue form {
        margin: 0px 0px 20px 350px;
        display: flex;
        align-items: center;
    }

    .search-input {
        padding: 5px 300px 5px 5px;
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
    }

    .search-button {
        margin-top: 5px;
        background: white;
    }

    .search-button button:hover {
        color: #0795c8d5;
    }

    .tablemember {
        margin-left: 45px;
    }

    .addmember {
        height: 35px;
        width: 95px;
        display: flex;
        align-items: center;
        padding: 5px;
        background-color: white;
        border: 2px solid black;
        color: black;
        border-radius: 4px;
        transition: ease .40s;
        margin-left: 50px;
    }

    .addmember:hover {
        background-color: #0795c8d5;
        border: transparent;
        color: #ffffff;
    }

    .addmember i {
        margin-right: 3px;
        font-size: 20px;
    }

    .addmember h4 {
        font-weight: 500;
    }

    table {
        border-collapse: collapse;
        margin: 5px 0;
        padding: 5px;
        font-size: 0.9em;
        font-family: sans-serif;
        box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.5), 0 -10px 10px -10px rgba(0, 0, 0, 0.5);
    }

    td,
    th {
        padding: 10px 40px;
        text-align: center;
    }

    thead {
        padding: 30px;
    }

    tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    thead tr {
        background-color: #0795c8d5;
        color: #ffffff;
        text-align: center;
    }

    tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }

    tbody tr:nth-of-type(even) {
        background-color: #eeeeee;
    }

    tr a {
        padding: 5px;
        margin: 5px;
        border-radius: 3px;
    }

    tr .production {
        background-color: #0795c8d5;
        color: white;
        font-weight: 500;
        transition: ease .40s;
    }

    tr .detail {
        background-color: #ffffff;
        border: 1.5px solid black;
        color: black;
        font-weight: 500;
        transition: ease .40s;
    }

    tr .detail:hover {
        background-color: #0795c8d5;
        color: white;
        font-weight: 500;
        border: transparent;
    }

    tr .production:hover {
        background-color: white;
        color: black;
        font-weight: 500;
        border: 1.5px solid black;
    }

    table h3 {
        font-size: 25px;
        text-transform: capitalize;
    }

    table span {
        color: #0795c8d5;
    }
    </style>

    <header>
        <a href="../index.html" class="logo"><img src="../images/logo_ufr_MI.png" alt=""></a>
        <a href="../index.html" class="list">Accueil</a>
    </header>

    <div class="contenue">
        <div class="search">
            <form action="search_cours.php" method="post">
                <div class="">
                    <input type="text" name="search-input" placeholder="recherche" class="search-input" required>
                </div>
                <div class="search-button">
                    <button name="valider"><i class='bx bx-search-alt-2'></i></button>
                </div>
            </form>
        </div>

        <div class="tablemember">
            <div class="addmember1">
                <a href="../connexion/enregistrer_edt.php" class="addmember">
                    <div><i class='bx bx-user-plus'></i></div>
                    <h4>Ajouter</h4>
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Date de debut</th>
                        <th>date de fin</th>
                        <th>Niveau</th>
                        <th>Année universitaire</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Exécuter une requête SQL pour récupérer tous les emplois du temps
                        $req = "SELECT cod_edt, date_debut, date_fin, niveau, annee_uni FROM emplois_du_temps ORDER BY cod_edt";
                        $resultat = $conn->query($req);
                        if(!$resultat){
                            die("Requete invalide");
                        }
                        while($row=$resultat->fetch_assoc()){
                            echo "
                    <tr>
                        <th>$row[date_debut]</th>
                        <td>$row[date_fin]</td>
                        <td>$row[niveau]</td>
                        <td>$row[annee_uni]</td>
                        <td><a href='download_edt.php?id=" . $row["cod_edt"] . "' class='detail'>Télécharger</a></td>
                    </tr>
                        ";
                           }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <caption>
                                <h3>Liste des <span>Emplois du temps</span></h3>
                            </caption>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>