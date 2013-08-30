<!DOCTYPE html>
<html>	
<head>
	<title>Gestion types trains</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion types trains</c></u></h1>
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
$PC = $_POST['PC'];
$SC = $_POST['SC'];
$Vit = $_POST['Vit'];
$Erreur = 0;

if (empty($Nom)) echo"Erreur: aucun nom de type de train entré!";		
else if (!isset($PC)) echo"$PC<br>Erreur: aucun nombre de premières classes entré!";
else if (!isset($SC)) echo"Erreur: aucun nombre de secondes classes entré!";
else if (!isset($Vit)) echo"Erreur: aucune vitesse maximale entrée!";
else{
	$query = "SELECT Nom_Type FROM projet.Type_Train";
	
	$result = pg_query($vConn, $query);
	//if(!$result) echo"Une erreur est survenue, veuillez réessayer...";
	//else{
		while($row = pg_fetch_row($result)) if ($row[0] == $Nom) $Erreur = 1;
		
		if ($Erreur) echo"Le type que vous essayez d'ajouter existe déjà dans la base de donnée";

		else{
			$query = "INSERT INTO projet.Type_Train VALUES ('".str_replace( "'", "''",$Nom)."', '$PC', '$SC', '$Vit')";
			$result = @pg_query($vConn, $query);
			
			if(empty($result)) echo"Une erreur est survenue, veuillez réessayer.";
			else echo"Le type de train $Nom a été ajoutée à la base de donnée avec succès.";
		}
	//}
}

pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_types_trains.php">Retour page précédente</a>



</body>
</html>