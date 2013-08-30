<!DOCTYPE html>
<html>	
<head>
	<title>Gestion gares</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion gares</c></u></h1>
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



$Nom = $_POST['Nom'];
$Ville = $_POST['Ville'];
$CP = $_POST['CP'];
//$CheckNom = 0;
//$CheckCP = 0;
//$CheckVille = 0;
$Check = 0;

if (empty($Nom)) echo"Erreur: aucun nom de gare entré!";		
else if (empty($CP)) echo"Erreur: aucun code postal entré!";
else if (empty($Ville)) echo"Erreur: aucune ville entrée!";
else{
	
	$query = "SELECT Nom, CP, Ville FROM projet.Gare";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		//if ($Nom==$row[0]) $CheckNom=1;
		//if ($CP==$row[2]) $CheckCP=1;
		//if ($Ville==$row[3]) $CheckVille=1;
		if ($Nom==$row[0] && $CP ==$row[1] && $Ville==$row[2]) $Check = 1;
	}
	
	if ($Check) {
		$query = "DELETE FROM projet.Gare WHERE Nom='$Nom' AND CP='$CP' AND Ville='$Ville'";
		$result = pg_query($vConn, $query);
		echo"La gare $Nom, a été retirée de la base de donnée avec succès.";
	}
	
	else echo"Erreur: Les données entrées ne correspondent à aucune gare dans la base de données. Veuillez vérifier l'exactitude du nom de la gare, de la ville dans laquelle elle se trouve et du code postal correspondant.";
}

pg_close($vConn);
}
?> 

<br><br>
<a href="gestion_gares.php">Retour page précédente</a>



</body>
</html>