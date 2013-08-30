<!DOCTYPE html>
<html>	
<head>
	<title>Menu client</title>
	<meta charset="utf-8" />
</head>
<body>
	
	<h1><center><u>Espace client</c></u></h1>
	
<?php
/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

session_start();
$session = $_SESSION['Login'];
$Id = $_SESSION['Id'];

$query = "SELECT nom, prenom FROM projet.voyageur, projet.personne WHERE voyageur.id = personne.id AND voyageur.login = '$session'";
$result = pg_query($vConn, $query);
$row = pg_fetch_array($result, null, PGSQL_ASSOC);

echo"Vous êtes connecté en tant que $row[prenom] $row[nom].<br>";
echo"Ce n'est pas vous? Déconnectez vous en <a href='deconnection.php'> cliquant ici</a>.<br><br>";

$NrT = $_POST['NrT']; 
$NrB = $_POST['NrB'];


$query = "DELETE FROM projet.Billet WHERE Num=$NrB AND Num_Trajet=$NrT";
$result = pg_query($vConn, $query);

if(empty($result)) echo"Un problème est survenu, veuillez nous en excuser.";
else echo"Votre annulation a été prise en compte. Vous allez être remboursés dans les plus brefs délais.";

pg_close($vConn);
?>

<br><br>
<a href="reservations.php">Retour à mes réservations</a>

</body>
</html>