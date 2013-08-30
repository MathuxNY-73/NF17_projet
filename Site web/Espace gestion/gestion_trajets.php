<!DOCTYPE html>
<html>	
<head>
	<title>Gestion des trajets</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion des trajets</c></u></h1>
<br><br>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{


/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

$query = "SELECT Nom, CP, Ville, Num FROM projet.Gare ORDER BY Nom";
$result = pg_query($vConn, $query);

echo"
<h2>Ajouter un nouveau trajet</h2>
<TABLE border=0>
	<form method='POST' action='ajout_trajet.php'>
		<TR><TD>Gare de départ :</TD> <TD><SELECT name='GareD'/>";
		while ($row = pg_fetch_row($result)) echo"<OPTION Value='$row[3]'>$row[0] ($row[1] $row[2])";
		echo"</SELECT></TD></TR>";

		$result = pg_query($vConn, $query);
		
		echo"
		<TR><TD>Gare d'arrivée :</TD> <TD><SELECT name='GareA'/>";
		while ($row = pg_fetch_row($result)) echo"<OPTION Value='$row[3]'>$row[0] ($row[1] $row[2])";
		echo"</SELECT></TD></TR>";
		
		echo"
		<TR><TD>Date de départ :</TD> <TD><INPUT type='text' name='DateD'/></TD></TR>
		<TR><TD></TD><TD>Format : AAAA-MM-JJ HH:MM</TD></TR>";
		
		echo"
		<TR><TD>Date d'arrivée :</TD> <TD><INPUT type='text' name='DateA'/></TD></TR>
		<TR><TD></TD><TD>Format : AAAA-MM-JJ HH:MM</TD></TR>";
		
		$query = "SELECT Num, Typet FROM projet.Train";
		$result = pg_query($vConn, $query);
		
		echo"
		<TR><TD>Nr train affecté :</TD> <TD><SELECT name='Train'/>";
		while ($row = pg_fetch_row($result)) echo"<OPTION Value = '$row[0]'>$row[0] ($row[1])";
		echo"</SELECT></TD></TR>";
		
echo"	
		<TR><TD>Prix 1ère:</TD><TD><INPUT TYPE='text' NAME='Prix1'></TD></TR>
		
		<TR><TD>Prix 2nde:</TD><TD><INPUT TYPE='text' NAME='Prix2'></TD></TR>
		
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
<br>
";

$query = "SELECT Num FROM projet.Trajet";
$result = pg_query($vConn, $query);

echo"	
<h2>Retirer un trajet</h2>
ATTENTION: Cette fonction n'est à utiliser que dans le cas d'une erreur de saisie lors de l'ajout d'un trajet à la base de données.<br>
Vous ne pouvez pas retirer un trajet pour lequel des billets ont déjà été vendus!

<TABLE border=0>
	<form method='POST' action='retrait_trajet.php'>
		<TR><TD>Nr :</TD> <TD><SELECT name='Nr'/>";
		while ($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		echo"</SELECT></TD></TR>";
echo"
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
<br>
";

/*
$query = "SELECT Num, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Num_Train FROM projet.Trajet";
$result = pg_query($vConn, $query);
*/

$query = "SELECT DISTINCT Ville_Depart FROM projet.Trajet ORDER BY Ville_Depart";
$result = pg_query($vConn, $query);

$date = @getdate();

echo"
<h2>Filtrer les trajets</h2>
Vous pouvez ne pas préciser d'heure de départ et d'arrivée.<br>
Par contre à partir du moment ou vous précisez une année, un mois ou un jour, il est nécessaire de renseigner les 3 champs.<br>
<TABLE border=0>
	<form method='POST' action='gestion_trajets.php'>";
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
	
		$query = "SELECT DISTINCT Num_Train FROM projet.Trajet ORDER BY Num_Train";
		$result = pg_query($vConn, $query);
	
		/*
		echo"
		<TR><TD>Nr train affecté :</TD> <TD><SELECT name='Train'/><OPTION>";
		while ($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		echo"</SELECT></TD></TR>";
		*/
		
		echo"
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
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
	$query = "SELECT Num, Num_Train, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2 FROM projet.Trajet WHERE Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Date_Depart >= '$DateD' AND Date_Depart <= '$DateDLim' AND Date_Arrivee >= '$DateA' AND Date_Arrivee <= '$DateALim' AND Prix1 <= $PMax AND Prix1 >= $PMin AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

else if($CheckDepart) {
	$query = "SELECT Num, Num_Train, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2 FROM projet.Trajet WHERE Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Date_Depart >= '$DateD' AND Date_Depart <= '$DateDLim' AND Prix1 <= $PMax AND Prix1 >= $PMin AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

else if($CheckArrivee){
	$query = "SELECT Num, Num_Train, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2 FROM projet.Trajet WHERE Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Date_Arrivee >= '$DateA' AND Date_Arrivee <= '$DateALim' AND Prix1 <= $PMax AND Prix1 >= $PMin AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

else{
	$query = "SELECT Num, Num_Train, Ville_Depart, Date_Depart, Ville_Arrivee, Date_Arrivee, Prix1, Prix2 FROM projet.Trajet WHERE Ville_Depart LIKE '$VilleD' AND Ville_Arrivee LIKE '$VilleA' AND Prix1 <= $PMax AND Prix1 >= $PMin AND Prix2 <= $PMax AND Prix2 >= $PMin ORDER BY Date_Depart";
}

$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Trajet numero</td><td>Train numero</td><td>Ville de départ</td><td>Date de départ</td><td>Ville d'arrivée</td><td>Date d'arrivée</td><td>Prix 1ère</td><td>Prix 2nde</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td></tr>";
}
echo"</table>";

pg_close($vConn);
?> 

<br><br><br>
<?php } ?>
<a href="menu_gestion.php">Retour page précédente</a>



</body>
</html>