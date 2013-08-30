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
$Adr = $_POST['Adr'];
$CP = $_POST['CP'];
$Ville = $_POST['Ville'];
$TPM = $_POST['TPM'];

//$CheckVille = 0;
//$CheckCP = 0;
$Check = 0;

if (empty($Nom)) echo"Erreur: aucun nom entré!";
else if (empty($Adr)) echo"Erreur: aucune adresse entrée!";
else if (empty($Ville)) echo"Erreur: aucune ville entrée!";
else if (empty($CP)) echo"Erreur: aucun code postal entré!";
else if (empty($TPM)) echo"Erreur: aucun nombre minimum de temps pleins entré!";
else{
	$query = "SELECT Nom, CP FROM projet.Ville";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		//if ($Ville==$row[0]) $CheckVille=1;
		//if ($CP==$row[1]) $CheckCP=1;
		if ($Ville==$row[0] && $CP ==$row[1]) $Check = 1;
	}

	if (!$Check) echo"Erreur: la ville et le CP entrés ne correspondent à aucune ville dans la base de donnée.<br>Si la gare que vous désirez ajouter à la base de donnée se situe dans une ville non répertoriée,<br> merci de bien vouloir d'abord ajouter la ville désirée dans la base.";
	
	else{
		$query = "INSERT INTO projet.Gare VALUES ('".str_replace( "'", "''",$Nom)."', '$Adr', '$CP', '$Ville', $TPM)";
		$result = pg_query($vConn, $query);

		echo"La gare $Nom a été ajoutée à la base de donnée avec succès.";
	}
}

pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_gares.php">Retour page précédente</a>



</body>
</html>