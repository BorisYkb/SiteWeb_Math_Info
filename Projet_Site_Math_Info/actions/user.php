<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Module utilisateur</title>
</head>
<body>

<style>

*{
    outline: none;
    border: none;
    text-decoration: none;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

.container {
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
  padding: 20px;
  border: 1px solid transparent;
}

.logo{
    font-size: 1.8rem;
    font-weight: 600;
    color: black;
    padding: 0 40px 0 0px;
}
.logo span{
    color: #08d80f;
}

.header{
  margin-left: 500px;
}

.header h1 {
  font-size: 24px;
  margin: 10px 0;
}

.content h2 {
  font-size: 20px;
  margin-bottom: 10px;
}

.h3{
    margin-left: 250px;
    margin-top: 40px;
}

.total{
    margin-left: 300px; 
}

table {
  width: 100%;
  border-collapse: collapse;
}

table th, table td {
  border: 1px solid #ccc;
  padding: 8px;
}

.footer {
  text-align: right;
  margin-top: 20px;
}

.footer button {
  padding: 10px 20px;
  background-color: #f44336;
  color: #fff;
  border: none;
  cursor: pointer;
}

.footer button:hover {
  background-color: #d32f2f;
}

</style>

  <div class="container">
    <div class="header">
      <a href="../../Web/Projet1.html" class="logo">Korhogo<span>Cashew</span></a>
      <p>01 BP 3579 KORHOGO 01</p>
    </div>
    <div class="content">
      <h2>Informations du planteur</h2>
      <?php
        require('../dbconnect.php');
        session_start();

        // Récupérer l'ID du planteur depuis l'URL
        $idPlanteur = $_GET['id'];

        // Récupérer les informations du planteur depuis la base de données
        $sqlPlanteur = "SELECT * FROM USER WHERE ID_USER = $idPlanteur";
        $resultatPlanteur = mysqli_query($conn, $sqlPlanteur);
        $planteur = mysqli_fetch_assoc($resultatPlanteur);

        $nomPlanteur = $planteur['NOM_USER'];
        $numPlanteur = $planteur['NUM_USER'];
        $mailPlanteur = $planteur['MAIL_USER'];

        echo '<p>Identifiant : ' . $idPlanteur . '</p>';
        echo '<p>Nom : ' . $nomPlanteur . '</p>';
        echo '<p>Télephone : ' . $numPlanteur . '</p>';
        echo '<p>Email : ' . $mailPlanteur . '</p>';

        // Récupérer les productions du planteur depuis la base de données
        $sqlProductions = "SELECT * FROM PRODUCTION WHERE ID_USER = $idPlanteur";
        $resultatProductions = mysqli_query($conn, $sqlProductions);

        if ($resultatProductions && mysqli_num_rows($resultatProductions) > 0) {
          echo '<h3 class="h3">Liste des productions</h3>';
          echo '<table>';
          echo '<thead><tr><th>N°</th><th>Date d\'enregistrement</th><th>Prix par kilogramme</th><th>Poids en tonne</th><th>Prix de production</th></tr></thead>';
          echo '<tbody>';

          $totalPoidsTonne = 0;
          $totalPrixProduction = 0;
          while ($production = mysqli_fetch_assoc($resultatProductions)) {
            $idProduction = $production['ID_PROD'];
            $dateEnregistrement = $production['DATE_ENREGIS'];
            $prixKg = $production['PRIX_KG'];
            $poidsTonne = $production['POIDS_TONNE'];

            $prixProduction = $prixKg * 1000 * $poidsTonne;

            echo '<tr><td>' . $idProduction . '</td><td>' . $dateEnregistrement . '</td><td>' . $prixKg . '</td><td>' . $poidsTonne . '</td><td>' . $prixProduction . '</td></tr>';

            $totalPoidsTonne += $poidsTonne;
            $totalPrixProduction += $prixProduction;
          }

          echo '</tbody>';
          echo '</table>';

          // Afficher les totaux
          echo '<h3 class="total">Totaux</h3>';
          echo '<table>';
          echo '<thead><tr><th>Date d\'établissement</th><th>Poids cumulé(en tonne)</th><th>Total prix de production</th></tr></thead>';
          echo '<tbody>';
          echo '<tr><td>' . date('Y-m-d') . '</td><td>' . $totalPoidsTonne . '</td><td>' . $totalPrixProduction . '</td></tr>';
          echo '</tbody>';
          echo '</table>';
        } else {
          echo '<p>Aucune production enregistrée.</p>';
        }

        mysqli_close($conn);
      ?>
    </div>
    <div class="footer">
      <button onclick="window.print()">Imprimé</button>
    </div>
  </div>
</body>

</html>
