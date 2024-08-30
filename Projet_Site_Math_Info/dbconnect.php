<?php

//paramètre de connection à la base de donneé
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CSI";

//connection a la base de donnée
$conn = new mysqli($servername, $username, $password, $dbname);

//vérification de le connexion de le base de donnée
if ($conn->connect_error){
	die("Imposible d'acceder au serveur, veillez réessayer plus tard:".$conn->connect_error);
}


?>