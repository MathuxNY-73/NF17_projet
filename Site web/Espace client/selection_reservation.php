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

$query = "	SELECT Gare_Depart, Ville_Depart, CP_Depart, Date_Depart, Gare_Arrivee, Ville_Arrivee, CP_Arrivee, Date_Arrivee, B.Prix, B.Classe, B.Num, T.Num, Train.Typet, B.Assurance 
			FROM projet.trajet T, projet.billet B, projet.Train
			WHERE B.Voyageur = $Id
			AND B.Num = $NrB
			AND T.Num = $NrT
			AND B.Num_Trajet = T.Num
			AND Train.Num = T.Num_Train";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);

if($row[13]=='t') $Assu="Oui";
else $Assu="Non";

echo"<table border=1 align='center'>";
echo"<tr><td>Gare de départ</td><td>Ville de départ</td><td>Date de départ</td><td>Gare d'arrivée</td><td>Ville d'arrivée</td><td>Date d'arrivée</td></tr>";
echo"<tr><td>$row[0]</td><td>$row[1]  ($row[2])</td><td>$row[3]</td><td>$row[4]</td><td>$row[5] ($row[6])</td><td>$row[7]</td></tr>";

echo"</table><br><br>";
echo"Prix: $row[8]€<br>
	Classe: $row[9]<br>
	Place: $row[10]<br>
	Trajet nr.: $row[11]<br>
	Type train: $row[12]<br>
	Assurance: $Assu<br><br>";

if($Assu=="Oui") echo"Vous avez souscrit à l'assurance, vous serez remboursé entièrement si vous annulez ce billet.<br>";
else echo"Vous n'avez pas souscrit à l'assurance, vous ne serez remboursé qu'à 90% du prix d'achat si vous annulez ce billet.<br>";

echo"<FORM METHOD='POST' ACTION='annulation_client.php'><INPUT TYPE='hidden' NAME='NrB' VALUE='$NrB'><INPUT TYPE='hidden' NAME='NrT' VALUE='$NrT'><INPUT TYPE='submit' value='Annuler ce billet'>";


pg_close($vConn);
?>

<br><br>
<a href="reservations.php">Retour à mes réservations</a>

</body>
</html>