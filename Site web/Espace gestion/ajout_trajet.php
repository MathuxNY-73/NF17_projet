<!DOCTYPE html>
<html>	
<head>
	<title>Gestion des trajets</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion des trajets</c></u></h1>
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

$GareD = $_POST['GareD'];
$GareA = $_POST['GareA'];
$DateD = $_POST['DateD'];
$DateA = $_POST['DateA'];
$Train = $_POST['Train'];
$Prix1 = $_POST['Prix1'];
$Prix2 = $_POST['Prix2'];

$query = "SELECT Nom, Ville, CP FROM projet.Gare WHERE Num = $GareD";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);

$query = "SELECT Nom, Ville, CP FROM projet.Gare WHERE Num = $GareA";
$result = pg_query($vConn, $query);
$rowA = pg_fetch_row($result);

$query = "INSERT INTO projet.Trajet VALUES (DEFAULT, '".str_replace( "'", "''",$row[0])."', '$row[1]', '$row[2]', '".str_replace( "'", "''",$rowA[0])."', '$rowA[1]', '$rowA[2]', '$DateD', '$DateA', $Train, $Prix1, $Prix2)";
$result = @pg_query($vConn, $query);

if(empty($result)) echo"Une erreur est survenue veuillez réessayer. Veillez à bien respecter la syntaxe indiquée pour les dates de départ et d'arrivée.";
else echo"Le trajet a bien été ajouté!";


pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_trajets.php">Retour page précédente</a>



</body>
</html>