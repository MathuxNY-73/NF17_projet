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

$query = "SELECT * FROM projet.Personne P WHERE P.Id = $Id";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);

echo"
<table border=0>
<tr><td>Nom :</td> <td>$row[1]</td></tr>
<tr><td>Prenom :</td> <td>$row[2]</td></tr>
<tr><td>Tel :</td> <td>$row[3]</td></tr>
<tr><td>Rue :</td> <td>$row[4]</td></tr>
<tr><td>CP :</td> <td>$row[5]</td></tr>
<tr><td>Ville :</td> <td>$row[6]</td></tr>
</table>
";

echo"
<FORM method='POST' action='modif_client.php'>
<table border=0><tr><td>Que voulez-vous modifier?</td>
					<td><SELECT Name='Choix'><OPTION>Nom<OPTION>Prenom<OPTION>Num_Tel</SELECT></td>
					<td><input type='text' name='New'></td>
					<td><input type='submit'></td></tr>
</FORM>
</table>

<table border=0>
<FORM method='POST' action='modif_adresse.php'>
				<tr><td></td><td>Votre adresse :</td><td>Rue :</td><td><input type='text' name='Rue'></td></tr>
				<tr><td></td><td></td>					<td>CP :</td><td><input type='text' name='CP'></td></tr>
				<tr><td></td><td></td>					<td>Ville :</td><td><input type='text' name='Ville'></td><td><input type='submit'></td></tr>
</FORM>
</table>
";			




pg_close($vConn);
?>

<br><br>
<a href="menu_client.php">Retour menu</a>

</body>
</html>