<!DOCTYPE html>
<html>	
<head>
	<title>Gestion points d'intérêt</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion points d'intérêt</c></u></h1>
<br><br><br>
	
<?php

session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{

/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");



$Nr = $_POST['Nr'];

if (empty($Nr)) echo"Erreur: aucun numéro entré!";		
else{
	$query = "SELECT Nom, Ville FROM projet.Point_Interet WHERE Num='$Nr'";
	$result = pg_query($vConn, $query);
	$row=pg_fetch_row($result);
	
	$query = "DELETE FROM projet.Point_Interet WHERE Num=$Nr";
	$result = pg_query($vConn, $query);
	echo"Le point d'intérêt numéro $Nr ($row[0] à $row[1]), a été retirée de la base de donnée avec succès.";
	}


pg_close($vConn);
}
?> 

<br><br>
<a href="gestion_interets.php">Retour page précédente</a>



</body>
</html>