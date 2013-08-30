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


$Classe = $_POST['Classe'];
$Assu = $_POST['Assu'];
$Mode = $_POST['Mode'];

$Trajet = $_POST['Trajet'];
$Prix1 = $_POST['Prix1'];
$Prix2 = $_POST['Prix2'];

if($Classe == 1) $Prix = $Prix1;
else $Prix = $Prix2;

if($Assu=='TRUE') $Prix *= 1.1;


//Récupération du nombre de places restantes
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

if(($PRest1>0 && $Classe==1) || ($PRest2>0 && $Classe==2)){ //SI IL RESTE DES PLACES
	//AFFICHAGE DES PLACES RESTANTES
	//récupération du nombre de premières classes
		$query = "SELECT TT.Nb_Prem FROM projet.Trajet Traj, projet.Train Train, projet.Type_Train TT WHERE Traj.Num = $Nr AND Train.Typet = TT.Nom_Type AND Train.Num = Traj.Num_Train";
		$result = pg_query($vConn, $query);
		$row = pg_fetch_row($result);
		$Places1 = $row[0];

		//récupération des numéros des place vendues
		$query = "SELECT Num FROM projet.billet WHERE num_trajet = $Nr AND classe = 1";
		$result = pg_query($vConn, $query);
		
		//stockage dans un tableau
		for($i=1 ; $i<=$Places1 ; $i++){
			$row = pg_fetch_row($result);
			$tab1[$i] = $row[0];
		}

	//récupération du nombre de seconde classes
		$query = "SELECT TT.Nb_Scnd FROM projet.Trajet Traj, projet.Train Train, projet.Type_Train TT WHERE Traj.Num = $Nr AND Train.Typet = TT.Nom_Type AND Train.Num = Traj.Num_Train";
		$result = pg_query($vConn, $query);
		$row = pg_fetch_row($result);
		$Places2 = $row[0];

		//récupération des numéros des secondes classes vendues
		$query = "SELECT Num FROM projet.billet WHERE num_trajet = $Nr AND classe = 2";
		$result = pg_query($vConn, $query);
		
		//stockage des numéros des places dans un tableau
		for($i=$Places1+1 ; $i<=$Places1+$Places2 ; $i++){
			$row = pg_fetch_row($result);
			$tab2[$i] = $row[0];
		}
	
	echo"<FORM METHOD='POST' ACTION='achat_billet_guichet.php'>";
	
	echo"
	
		<input type='hidden' name='Classe' value='$Classe'>
		<input type='hidden' name='Assu' value='$Assu'>
		<input type='hidden' name='Trajet' value='$Trajet'>
		<input type='hidden' name='Prix1' value='$Prix1'>
		<input type='hidden' name='Prix2' value='$Prix2'>
		<input type='hidden' name='Mode' value='$Mode'>
		";
	
	echo"<SELECT Name='Place'>";
	echo"Choisissez votre place:";
	
	if($Classe==1){
		
		for($i=1 ; $i<=$Places1 ; $i++){
			
			if(!in_array($i, $tab1)) echo"<OPTION>$i";
		
		}
		
		echo"</SELECT>";
		echo"<INPUT TYPE='SUBMIT'></FORM>";
	}

	if($Classe==2){
		
		for($i=$Places1+1 ; $i<=$Places1+$Places2 ; $i++){
			
			if(!in_array($i, $tab2)) echo"<OPTION>$i";
		
		}
		
		echo"</SELECT>";
		echo"<INPUT TYPE='SUBMIT'></FORM>";
	}
}

pg_close($vConn);
}
?>
<br><br>
<a href="menu_billettique.php">Retour recherche</a>

</body>
</html>