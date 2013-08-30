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



$Nom = $_POST['Nom'];
$Adr = $_POST['Adr'];
$CP = $_POST['CP'];
$Ville = $_POST['Ville'];
$Gare1 = $_POST['Gare1'];
$Gare2 = $_POST['Gare2'];
$Gare3 = $_POST['Gare3'];
$Type = $_POST['Type'];

//$CheckVille = 0;
//$CheckCP = 0;
$Check = 0;
$Check2 = 0;
$Check3 = 0;

if (empty($Nom)) echo"Erreur: aucun nom entré!";
else if (empty($Adr)) echo"Erreur: aucune adresse entrée!";
else if (empty($Ville)) echo"Erreur: aucune ville entrée!";
else if (empty($CP)) echo"Erreur: aucun code postal entré!";
else if (empty($Type)) echo"Erreur: aucun type spécifié!";
else if (empty($Gare1)) echo"Erreur: aucune gare associée spécifiée!";
else{
	$query = "SELECT Ville, CP, Nom FROM projet.Gare";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		//if ($Ville==$row[0]) $CheckVille=1;
		//if ($CP==$row[1]) $CheckCP=1;
		if ($Ville==$row[0] && $CP ==$row[1] && $Gare1==$row[2]) $Check = 1;
	}
	
	$query = "SELECT Ville, CP, Nom FROM projet.Gare";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		//if ($Ville==$row[0]) $CheckVille=1;
		//if ($CP==$row[1]) $CheckCP=1;
		if ($Ville==$row[0] && $CP ==$row[1] && $Gare2==$row[2]) $Check2 = 1;
	}
	
	$query = "SELECT Ville, CP, Nom FROM projet.Gare";
	$result = pg_query($vConn, $query);
	while($row = pg_fetch_row($result)){
		//if ($Ville==$row[0]) $CheckVille=1;
		//if ($CP==$row[1]) $CheckCP=1;
		if ($Ville==$row[0] && $CP ==$row[1] && $Gare3==$row[2]) $Check3 = 1;
	}

	if (!$Check) echo"Erreur: la ville, le CP et la première gare entrés ne correspondent à aucune gare dans la base de donnée.<br>Si le point d'intérêt que vous désirez ajouter à la base de donnée est associé à une gare non répertoriée,<br> merci de bien vouloir d'abord ajouter la gare désirée dans la base.";
	else if(!empty($Gare2) && !$Check2) echo"Erreur: la ville, le CP et la seconde gare entrés ne correspondent à aucune gare dans la base de donnée.<br>Si le point d'intérêt que vous désirez ajouter à la base de donnée est associé à une gare non répertoriée,<br> merci de bien vouloir d'abord ajouter la gare désirée dans la base.";
	else if(!empty($Gare3) && !$Check3) echo"Erreur: la ville, le CP et la troisième gare entrés ne correspondent à aucune gare dans la base de donnée.<br>Si le point d'intérêt que vous désirez ajouter à la base de donnée est associé à une gare non répertoriée,<br> merci de bien vouloir d'abord ajouter la gare désirée dans la base.";
	
	else{
		$query = "INSERT INTO projet.Point_Interet VALUES (DEFAULT, '".str_replace( "'", "''",$Nom)."', '".str_replace( "'", "''", $Adr )."', '".str_replace( "'", "''",$CP)."', '".str_replace( "'", "''",$Ville)."', '$Type')";
		$result = pg_query($vConn, $query);
		
		$query = "SELECT Num FROM projet.Point_Interet WHERE Nom='".str_replace( "'", "''",$Nom)."' AND CP='".str_replace( "'", "''",$CP)."' AND Ville='".str_replace( "'", "''",$Ville)."'";
		$result = pg_query($vConn, $query);
		$row = pg_fetch_row($result);
		
		$query = "INSERT INTO projet.Gare_Interet VALUES ('$row[0]', '".str_replace( "'", "''",$Gare1)."', '".str_replace( "'", "''", $Ville)."', '".str_replace( "'", "''",$CP)."')";
		$result = pg_query($vConn, $query);
		
		if(!empty($Gare2)){
			$query = "INSERT INTO projet.Gare_Interet VALUES ('$row[0]', '".str_replace( "'", "''",$Gare2)."', '".str_replace( "'", "''", $Ville)."', '".str_replace( "'", "''",$CP)."')";
			$result = pg_query($vConn, $query);
		}
		
		if(!empty($Gare3) && !empty($Gare2)){
			$query = "INSERT INTO projet.Gare_Interet VALUES ('$row[0]', '".str_replace( "'", "''",$Gare3)."', '".str_replace( "'", "''", $Ville)."', '".str_replace( "'", "''",$CP)."')";
			$result = pg_query($vConn, $query);
		}

		echo"Le point d'intérêt $Nom a été ajoutée à la base de donnée avec succès.";
	}
}

pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_interets.php">Retour page précédente</a>



</body>
</html>