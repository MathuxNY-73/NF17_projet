<!DOCTYPE html>
<html>	
<head>
	<title>Menu billettique</title>
	<meta charset="utf-8" />
</head>
<body>
	
	<h1><center><u>Espace billettique</c></u></h1>
	
<?php
session_start();
if(!isset($_SESSION['Billettique']) || !$_SESSION['Billettique']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{

/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

$NrB = $_POST['NrB'];
$NrT = $_POST['NrT'];

$query = "DELETE FROM projet.Billet WHERE Num=$NrB AND Num_Trajet=$NrT";
$result = pg_query($vConn, $query);

if(empty($result)) echo"Un problème est survenu, veuillez nous en excuser.";
else echo"L'annulation a bien été prise en compte.";

pg_close($vConn);
}
?>



<a href="menu_billettique.php">Retour menu</a>

</body>
</html>