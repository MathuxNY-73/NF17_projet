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

$Place = $_POST['Place'];
$Classe = $_POST['Classe'];
$Assu = $_POST['Assu'];

$Trajet = $_POST['Trajet'];
$Prix1 = $_POST['Prix1'];
$Prix2 = $_POST['Prix2'];

if($Classe == 1) $Prix = $Prix1;
else $Prix = $Prix2;

if($Assu=='TRUE') $Prix *= 1.1;

//Récupération du nombre de places restantes ////////////////////////////////
$Nr = $_POST['Trajet'];

$query = "SELECT Count(Num) FROM projet.billet WHERE num_trajet = $Nr AND classe = 1";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);
$PVendues1 = $row[0]; //récupération du nombre de 1ères vendues pour le trajet

$query = "SELECT Count(Num) FROM projet.billet WHERE num_trajet = $Nr AND classe = 2";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);
$PVendues2 = $row[0]; //récupération du nombre de secondes vendues pour le trajet

$query = "SELECT TT.Nb_Prem FROM projet.Trajet Traj, projet.Train Train, projet.Type_Train TT WHERE Traj.Num = $Nr AND Train.Typet = TT.Nom_Type AND Train.Num = Traj.Num_Train";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);
$Places1 = $row[0];

$query = "SELECT TT.Nb_Scnd FROM projet.Trajet Traj, projet.Train Train, projet.Type_Train TT WHERE Traj.Num = $Nr AND Train.Typet = TT.Nom_Type AND Train.Num = Traj.Num_Train";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);
$Places2 = $row[0];

$PRest1 = $Places1-$PVendues1;
$PRest2 = $Places2-$PVendues2;
//////////////////////////////////////////////////////////////////////

//Récupération du numéro de billet (obsolète)
/*
$query = "SELECT Num FROM projet.billet WHERE num_trajet = $Trajet";
$result = pg_query($vConn, $query);
$NumBillet = 0;
while ($row = pg_fetch_row($result)) $NumBillet = $row[0];
$NumBillet++;
*/

if(($PRest1>0 && $Classe==1) || ($PRest2>0 && $Classe==2)){
	$query = "INSERT INTO projet.billet VALUES ($Place, $Prix, 'Carte de Credit', TRUE, $Assu, $Id, $Trajet, $Classe)";
	$result = pg_query($vConn, $query);
	if(empty($result)) echo"Une erreur est survenue...";
	else echo"Votre achat a été pris en compte! Rendez-vous dans votre espace client pour gérer vos réservations.";
}

else echo"Désolé, mais il n'y a plus de place disponible pour la classe demandée.";


pg_close($vConn);
?>
<br><br>
<a href="recherche_trajets.php">Retour recherche</a>

</body>
</html>