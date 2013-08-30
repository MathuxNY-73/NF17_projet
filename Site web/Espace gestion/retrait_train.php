<!DOCTYPE html>
<html>	
<head>
	<title>Gestion des trains</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion des trains</c></u></h1>
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

$query = "DELETE FROM projet.Train WHERE Num = '$Nr'";
$result = @pg_query($vConn, $query);

if(empty($result)) echo"Une erreur est survenue, veuillez réessayer!";
else echo"Le train numero $Nr a été retiré de la base de donnée avec succès.";


pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_trains.php">Retour page précédente</a>



</body>
</html>