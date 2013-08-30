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

$Rue = $_POST['Rue'];
$CP = $_POST['CP'];
$Ville = $_POST['Ville'];

$query = "UPDATE projet.Personne 
			SET Rue = '$Rue', CP = '$CP', Ville='$Ville' WHERE Id = $Id";
$result = pg_query($vConn, $query);

if(empty($result)) echo"Erreur...";
else echo"La modification a bien été prise en compte";


pg_close($vConn);
?>

<br><br>
<a href="menu_client.php">Retour menu</a>

</body>
</html>