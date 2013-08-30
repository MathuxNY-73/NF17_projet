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


//Filtre et recherche de trajets
$query = "SELECT DISTINCT Ville_Depart FROM projet.Trajet ORDER BY Ville_Depart";
$result = pg_query($vConn, $query);

$date = @getdate();

echo"
<h2>Annuler un billet</h2>

<form method='post' action='annulation_billettique.php'>
<table border=0>
<tr><td>Numéro trajet :</td><td><input type='text' name='NrT'></td></tr>
<tr><td>Numéro place :</td><td><input type='text' name='NrB'></td></tr>
<tr><td></td><td><input type='submit'></td></tr>
</form>
</table>
";




echo"
<h2>Rechercher un trajet</h2>
<i>Vous pouvez ne pas préciser d'heure de départ et d'arrivée.<br>
Par contre à partir du moment où vous précisez une année, un mois ou un jour, il est nécessaire de renseigner les 3 champs.</i><br>
<TABLE border=0>
	<form method='POST' action='menu_billettique.php'>";
		echo"
		<TR><TD>Ville de départ :</TD> <TD><SELECT name='VilleD'/><OPTION>";
		while ($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		echo"</SELECT></TD></TR>";
		
		echo"
		<TR><TD>Date de départ :</TD>";
			echo"<TD>Année:<SELECT name='AnD'/><OPTION>"; for ($i=$date['year']; $i<=$date['year']+1;  $i++) echo"<OPTION>$i"; echo"</SELECT></TD>";
			echo"<TD>Mois:<SELECT name='MoisD'/><OPTION>"; for ($i=1; $i<=12;  $i++) echo"<OPTION>$i"; echo"</SELECT></TD>";
			echo"<TD>Jour:<SELECT name='JourD'/><OPTION>"; for ($i=1; $i<=31;  $i++) echo"<OPTION>$i"; echo"</SELECT></TD>";
			echo"<TD>A partir de:</TD><TD><SELECT name='HeureD'/><OPTION>"; for ($i=0; $i<=23;  $i++) echo"<OPTION>$i"; echo"</SELECT>heure</TD>";
		echo"</TR>";

		
		$query = "SELECT DISTINCT Ville_Arrivee FROM projet.Trajet ORDER BY Ville_Arrivee";
		$result = pg_query($vConn, $query);
		
		echo"
		<TR><TD>Ville d'arrivée :</TD> <TD><SELECT name='VilleA'/><OPTION>";
		while ($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		echo"</SELECT></TD></TR>";
		
		echo"
		<TR><TD>Date d'arrivée :</TD>";
			echo"<TD>Année:<SELECT name='AnA'/><OPTION>"; for ($i=$date['year']; $i<=$date['year']+1;  $i++) echo"<OPTION>$i"; echo"</SELECT></TD>";
			echo"<TD>Mois:<SELECT name='MoisA'/><OPTION>"; for ($i=1; $i<=12;  $i++) echo"<OPTION>$i"; echo"</SELECT></TD>";
			echo"<TD>Jour:<SELECT name='JourA'/><OPTION>"; for ($i=1; $i<=31;  $i++) echo"<OPTION>$i"; echo"</SELECT></TD>";
			echo"<TD>A partir de:</TD><TD><SELECT name='HeureA'/><OPTION>"; for ($i=0; $i<=23;  $i++) echo"<OPTION>$i"; echo"</SELECT>heure</TD>";
		echo"</TR>";
		
		echo"
		<TR><TD>Prix max:</TD><TD><input type='text' name='PMax'></TD></TR>
		
		<TR><TD>Prix min:</TD><TD><input type='text' name='PMin'></TD></TR>
		";
		
		echo"
		<TR><TD></TD><TD><input type='submit' value='Rechercher'/></TD></TR>
	</form>
	</TABLE>
";

//affichage des trajets
$VilleD = "%";
$VilleA = "%";

$DateD = "";
$DateA = "";

$AnD = $date['year'];
$MoisD = $date['mon'];
$JourD = $date['mday'];
$HeureD = 0;

$AnA = $date['year'];
$MoisA = $date['mon'];
$JourA = $date['mday'];
$HeureA = 0;

$PMax = 9999;
$PMin = 0;

$CheckDepart = 0;
$CheckArrivee = 0;

if(!empty($_POST['VilleD'])) $VilleD = $_POST['VilleD'];
if(!empty($_POST['VilleA'])) $VilleA = $_POST['VilleA'];

if(!empty($_POST['AnD']) && !empty($_POST['MoisD']) && !empty($_POST['JourD'])){
	$AnD = $_POST['AnD'];
	$MoisD = $_POST['MoisD'];
	$JourD = $_POST['JourD'];
	
	if(!empty($_POST['HeureD'])) $HeureD = $_POST['HeureD'];
	
	$DateD = $AnD."-".$MoisD."-".$JourD." ".$HeureD.":00";
	$DateDLim = $AnD."-".$MoisD."-".$JourD." 23:59:59";
	$CheckDepart = 1;
}

if(!empty($_POST['AnA']) && !empty($_POST['MoisA']) && !empty($_POST['JourA'])){
	$AnA = $_POST['AnA'];
	$MoisA = $_POST['MoisA'];
	$JourA = $_POST['JourA'];
	
	if(!empty($_POST['HeureA'])) $HeureA = $_POST['HeureA'];
		
	$DateA = $AnA."-".$MoisA."-".$JourA." ".$HeureA.":00";
	$DateALim = $AnA."-".$MoisA."-".$JourA." 23:59:59";
	$CheckArrivee = 1;
}

if(!empty($_POST['PMax'])) $PMax = $_POST['PMax'];
if(!empty($_POST['PMin'])) $PMin = $_POST['PMin'];


if($CheckDepart && $CheckArrivee){
	$query = "SELECT Typet, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2, Traj.Num FROM projet.Trajet Traj, projet.Train T WHERE Num_Train = T.Num AND Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Date_Depart >= '$DateD' AND Date_Depart <= '$DateDLim' AND Date_Arrivee >= '$DateA' AND Date_Arrivee <= '$DateALim' AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

else if($CheckDepart) {
	$query = "SELECT Typet, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2, Traj.Num FROM projet.Trajet Traj, projet.Train T WHERE Num_Train = T.Num AND Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Date_Depart >= '$DateD' AND Date_Depart <= '$DateDLim' AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

else if($CheckArrivee){
	$query = "SELECT Typet, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2, Traj.Num FROM projet.Trajet Traj, projet.Train T WHERE Num_Train = T.Num AND Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Date_Arrivee >= '$DateA' AND Date_Arrivee <= '$DateALim' AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

else{
	$query = "SELECT Typet, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2, Traj.Num FROM projet.Trajet Traj, projet.Train T WHERE Num_Train = T.Num AND Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Prix1 >= $PMin AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

$result = pg_query($vConn, $query);



echo"<table border=1 align='center'>";
echo"<tr><td>Ville de départ</td><td>Date de départ</td><td>Ville d'arrivée</td><td>Date d'arrivée</td><td>Type train</td><td>Prix 1ère</td><td>Prix 2nde</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[0]<td>$row[5]€</td><td>$row[6]€</td><td><FORM METHOD='POST' ACTION='selection_trajet_billettique.php'><input type='hidden' name='Nr' value='$row[7]'><input type='submit' value='Choisir'></FORM></td></tr>";
}
echo"</table>";



pg_close($vConn);
}
?>



<a href="../accueil.php">Retour accueil</a>

</body>
</html>