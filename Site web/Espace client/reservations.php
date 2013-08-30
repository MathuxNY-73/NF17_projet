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


echo"<h1>Vos réservations</h1>";

echo"<i>Pour plus de détails sur une réservation ou pour l'annuler, cliquez sur ''Choisir'' dans la liste.</i><br><br>"; 

$query = "SELECT Ville_Depart, CP_Depart, Date_Depart, Ville_Arrivee, CP_Arrivee, Date_Arrivee, B.Prix, B.Num, T.Num FROM projet.trajet T, projet.billet B WHERE B.Voyageur = $Id AND B.Num_Trajet = T.Num ORDER BY Date_Depart";
$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Ville de départ</td><td>Date de départ</td><td>Ville d'arrivée</td><td>Date d'arrivée</td><td>Prix</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0] ($row[1])</td><td>$row[2]</td><td>$row[3] ($row[4])</td><td>$row[5]</td><td>$row[6]€</td><td><FORM METHOD='POST' ACTION='selection_reservation.php'><input type='hidden' name='NrB' value='$row[7]'><input type='hidden' name='NrT' value='$row[8]'><input type='submit' value='Choisir'></FORM></td></tr>";
}
echo"</table>";




pg_close($vConn);
?>


<a href="menu_client.php">Retour menu</a>

</body>
</html>