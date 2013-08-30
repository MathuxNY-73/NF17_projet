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
$CP = $_POST['CP'];
$CheckNom = 0;
$CheckCP = 0;
$Check = 0;
$Erreur = 0;

if (empty($Nom)) echo"Erreur: aucun nom de ville entré!";		
else if (empty($CP)) echo"Erreur: aucun code postal entré!";
else{
	$query = "SELECT Nom, CP FROM projet.Ville";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		if ($Nom==$row[0]) $CheckNom=1;
		if ($CP==$row[1]) $CheckCP=1;
		if ($Nom==$row[0] && $CP ==$row[1]) $Check = 1;
	}
	
	
	$query = "SELECT Ville, CP FROM projet.Personne";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		if ($Nom==$row[0] && $CP==$row[1]) $Erreur=1;
	}
	
	if($Erreur) echo"La ville que vous essayez de supprimer est référencée en tant que ville de provenance d'un ou de plusieurs clients. Vous ne pouvez pas la supprimer da la base de données!";
	
	else if ($Check) {
		$query = "DELETE FROM projet.Ville WHERE Nom='$Nom' AND CP='$CP'";
		$result = pg_query($vConn, $query);
		echo"La ville $Nom, de code postal $CP a été retirée de la base de donnée avec succès.";
	}
	
	else if (!$CheckNom && !$CheckCP) echo"Erreur: La ville et le code postal entrés n'existent pas dans la base.";
	else if ($CheckNom && $CheckCP) echo"Erreur: La ville et le code postal entrés ne sont pas associés.";
	else if (!$CheckNom) echo"Erreur: La ville entrée n'existe pas dans la base.";
	else if (!$CheckCP) echo"Erreur: Le code postal entré n'existe pas dans la base.";	
}

pg_close($vConn);
}
?> 

<br><br>
<a href="gestion_villes.php">Retour page précédente</a>



</body>
</html>