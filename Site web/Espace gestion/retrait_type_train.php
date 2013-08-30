<!DOCTYPE html>
<html>	
<head>
	<title>Gestion Villes</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion villes</c></u></h1>
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
$Erreur = 1;
$Erreur2 = 0;

if (empty($Nom)) echo"Erreur: aucun type entré!";		

else{
	$query = "SELECT Nom_Type FROM projet.Type_Train";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		if ($Nom==$row[0]) $Erreur=0;
	}
	
	if($Erreur) echo"Erreur: le train que vous essayez de supprimer n'est pas dans la base!";
	
	else {
		$query = "SELECT Typet FROM projet.Train";
		$result = pg_query($vConn, $query);
		while($row = pg_fetch_row($result)){
			if ($Nom==$row[0]) $Erreur2=1;
		}
		
		if ($Erreur2) echo"Erreur: le type que vous essayez de supprimer est référencé par un ou plusieurs trains.";
		else{
			$query = "DELETE FROM projet.Type_Train WHERE Nom_Type='$Nom'";
			$result = pg_query($vConn, $query);
			echo"Le type $Nom a été retiré de la base de donnée avec succès.";
		}
	}
}

pg_close($vConn);
}
?> 

<br><br>
<a href="gestion_types_trains.php">Retour page précédente</a>



</body>
</html>