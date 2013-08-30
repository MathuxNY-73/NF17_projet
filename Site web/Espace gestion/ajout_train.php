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



$Type = $_POST['Type'];

$query = "INSERT INTO projet.Train VALUES (DEFAULT, '$Type')";
$result = pg_query($vConn, $query);

$query = "SELECT Num FROM projet.Train";
$result = @pg_query($vConn, $query);
while($row = @pg_fetch_row($result)) $Nr = $row[0];

if(empty($result)) echo"Une erreur est survenue, veuillez réessayer!";
else echo"Le train numero $Nr a été ajoutée à la base de donnée avec succès.";


pg_close($vConn);

}
?> 

<br><br>
<a href="gestion_trains.php">Retour page précédente</a>



</body>
</html>