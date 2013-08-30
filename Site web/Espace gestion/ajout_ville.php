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



$Nom = $_POST['NomAjout'];
$CP = $_POST['CPAjout'];
$Zone = $_POST['Zone'];

if (empty($Nom)) echo"Erreur: aucun nom de ville entré!";		
else if (empty($CP)) echo"Erreur: aucun code postal entré!";
else{
	if (empty($Zone)) $Zone = 0;
	$query = "INSERT INTO projet.Ville VALUES ('".str_replace( "'", "''",$Nom)."', '".str_replace( "'", "''",$CP)."', '$Zone')";
	$result = @pg_query($vConn, $query);
	if(empty($result)) echo"Une erreur est survenue, veuillez réessayer...";

	else echo"La ville $Nom de code postal $CP a été ajoutée à la base de donnée avec succès.";
}

pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_villes.php">Retour page précédente</a>



</body>
</html>