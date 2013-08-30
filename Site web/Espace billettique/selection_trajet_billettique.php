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


$Nr = $_POST['Nr'];

//Récupération du nombre de places restantes
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


echo"<h2>Récapitulatif trajet</h2>";



$query = "SELECT * FROM projet.Trajet Traj, projet.Train T WHERE Traj.Num = $Nr AND Num_Train = T.Num";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);

$PR1 = $row[10];
$PR2 = $row[11];


echo"<table border=1 align='center'>";
echo"<tr><td>Gare de départ</td><td>Ville de départ</td><td>Date de départ</td><td>Gare d'arrivée</td><td>Ville d'arrivée</td><td>Date d'arrivée</td><td>Type train</td><td>Prix 1ère</td><td>Prix 2nde</td></tr>";
echo"<tr><td>$row[1]</td><td>$row[2] ($row[3])</td><td>$row[7]</td><td>$row[4]</td><td>$row[5] ($row[6])</td><td>$row[8]</td><td>$row[13]</td><td>$PR1 €</td><td>$PR2 €</tr>";
echo"</table><br><br>";

echo"Nombre de places restantes en 1ère classe: $PRest1<br>";
echo"Nombre de places restantes en 2nde classe: $PRest2<br><br><br>";

//Affichage des points d'intérêts en gare d'arrivée
echo"<h3>A votre arrivée, vous pourrez bénéficier des services suivants:</h3>";

$query = "SELECT Nom, Rue, Type_Interet FROM projet.Point_Interet, projet.Gare_Interet WHERE Num = Num_Interet AND Gare = '".str_replace( "'", "''",$row[4])."' AND VilleGare = '$row[5]' AND CPGare = '$row[6]'";
$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Nom</td><td>Adresse</td><td>Type</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
}
echo"</table><br><br>";


echo"<h2>Vendre un billet pour ce trajet</h2>";

if($PRest1<=0 && $PRest2<=0) echo"Nous sommes désolé mais il n'y a plus de places pour le trajet que vous avez séléctionné.";

else if($PRest1<=0){ //si il ne reste plus que des seconde classe
	echo"
	<TABLE>
	<FORM METHOD='POST' ACTION='selection_place_billettique.php'>
	<TR><TD>Classe :</TD><TD><SELECT NAME='Classe'><OPTION>2</SELECT></TD><TD><i>Il n'y a plus de places en 1ère classe disponibles sur ce train.</i></TD></TR>
	<TR><TD>Désirez vous prendre l'assurance?</TD><TD><SELECT NAME='Assu'><OPTION VALUE='FALSE'>Non<OPTION VALUE='TRUE'>Oui</SELECT></TD><TD><i>L'assurance vous permet d'annuler votre billet gratuitement alors que 10% du prix du billet sera retenu autrement.</i></TD></TR>
	<TR><TD></TD><TD></TD><TD><i>L'assurance coûte 10% du prix du billet.</i></TD></TR>
	<TR><TD>Mode de paiement :</TD><TD><SELECT NAME='Mode'><OPTION>Carte de Credit<OPTION>Espece<OPTION>Cheque</SELECT></TD></TR>

	<input type='hidden' name='Trajet' value='$Nr'>
	<input type='hidden' name='Prix1' value='$PR1'>
	<input type='hidden' name='Prix2' value='$PR2'>

	<TR><TD></TD><TD><input type='submit' value='Valider achat'/></TD></TR>
	</FORM>
	</TABLE>
	";
}

else if($PRest2<=0){ //si il ne reste plus que des première classe
	echo"
	<TABLE>
	<FORM METHOD='POST' ACTION='selection_place_billettique.php'>
	<TR><TD>Classe :</TD><TD><SELECT NAME='Classe'><OPTION>1</SELECT></TD><TD><i>Il n'y a plus de places en 2nde classe disponibles sur ce train.</i></TD></TR>
	<TR><TD>Désirez vous prendre l'assurance?</TD><TD><SELECT NAME='Assu'><OPTION VALUE='FALSE'>Non<OPTION VALUE='TRUE'>Oui</SELECT></TD><TD><i>L'assurance vous permet d'annuler votre billet gratuitement alors que 10% du prix du billet sera retenu autrement.</i></TD></TR>
	<TR><TD></TD><TD></TD><TD><i>L'assurance coûte 10% du prix du billet.</i></TD></TR>
	<TR><TD>Mode de paiement :</TD><TD><SELECT NAME='Mode'><OPTION>Carte de Credit<OPTION>Espece<OPTION>Cheque</SELECT></TD></TR>

	<input type='hidden' name='Trajet' value='$Nr'>
	<input type='hidden' name='Prix1' value='$PR1'>
	<input type='hidden' name='Prix2' value='$PR2'>

	<TR><TD></TD><TD><input type='submit' value='Valider achat'/></TD></TR>
	</FORM>
	</TABLE>
	";
}


else{ //si il reste des 1eres et 2ndes
	echo"
	<TABLE>
	<FORM METHOD='POST' ACTION='selection_place_billettique.php'>
	<TR><TD>Classe :</TD><TD><SELECT NAME='Classe'><OPTION>1<OPTION>2</SELECT></TD></TR>
	<TR><TD>Désirez vous prendre l'assurance?</TD><TD><SELECT NAME='Assu'><OPTION VALUE='FALSE'>Non<OPTION VALUE='TRUE'>Oui</SELECT></TD><TD><i>L'assurance vous permet d'annuler votre billet gratuitement alors que 10% du prix du billet sera retenu autrement.</i></TD></TR>
	<TR><TD></TD><TD></TD><TD><i>L'assurance coûte 10% du prix du billet.</i></TD></TR>
	<TR><TD>Mode de paiement :</TD><TD><SELECT NAME='Mode'><OPTION>Carte de Credit<OPTION>Espece<OPTION>Cheque</SELECT></TD></TR>

	<input type='hidden' name='Trajet' value='$Nr'>
	<input type='hidden' name='Prix1' value='$PR1'>
	<input type='hidden' name='Prix2' value='$PR2'>

	<TR><TD></TD><TD><input type='submit' value='Valider achat'/></TD></TR>
	</FORM>
	</TABLE>
	";
}






pg_close($vConn);
}
?>
<br><br>
<a href="menu_billettique.php">Retour recherche</a>

</body>
</html>