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

$Place = $_POST['Place'];
$Classe = $_POST['Classe'];
$Assu = $_POST['Assu'];
$Mode = $_POST['Mode'];

$Trajet = $_POST['Trajet'];
$Prix1 = $_POST['Prix1'];
$Prix2 = $_POST['Prix2'];

if($Classe == 1) $Prix = $Prix1;
else $Prix = $Prix2;

if($Assu=='TRUE') $Prix = number_format($Prix*1.1, 2);

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
//////////////////////////////////

if(($PRest1>0 && $Classe==1) || ($PRest2>0 && $Classe==2)){
	$query = "INSERT INTO projet.billet VALUES ($Place, $Prix, '$Mode', TRUE, $Assu, 1, $Trajet, $Classe)";
	$result = pg_query($vConn, $query);
	if(empty($result)) echo"Une erreur est survenue...";
	else echo"La vente a bien été effectuée.<br>*IMPRESSION DU BILLET*";
}

else echo"Désolé, mais il n'y a plus de place disponible pour la classe demandée.";







pg_close($vConn);
}
?>
<br><br>
<a href="menu_billettique.php">Retour recherche</a>

</body>
</html>