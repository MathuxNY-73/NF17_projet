<!DOCTYPE html>
<html>	
<head>
	<title>Gestion types trains</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion types de trains</c></u></h1>
<br><br>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>

<h2>Ajouter un nouveau type de train</h2>
<TABLE border=0>
	<form method="POST" action="ajout_type_train.php">
		<TR><TD>Nom du type :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>Nombre de places en 1ere classe :</TD> <TD><input type="text" name="PC"/></TD></TR>
		<TR><TD>Nombre de places en 2nde classe :</TD> <TD><input type="text" name="SC"/></TD></TR>
		<TR><TD>Vitesse maximale :</TD> <TD><input type="text" name="Vit"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
<br>
	
<h2>Retirer un type de train</h2>
ATTENTION: Cette fonction est à utiliser que dans le cas d'une erreur de saisie lors de l'ajout d'un type de train à la base de données.<br>
Vous ne pouvez pas retirer un type de train pour lequel des trains existent dans la base.

<TABLE border=0>
	<form method="POST" action="retrait_type_train.php">
		<TR><TD>Nom du type :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
<br>
	
<h2>Filtrer les types de trains</h2>
<TABLE border=0>
	<form method="POST" action="gestion_types_trains.php">
		<TR><TD>Nom du type:</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>Nombre minimum de places en 1ere classe :</TD> <TD><input type="text" name="PCMin"/></TD></TR>
		<TR><TD>Nombre maximum de places en 1ere classe :</TD> <TD><input type="text" name="PCMax"/></TD></TR>
		<TR><TD>Nombre minimum de places en 2nde classe :</TD> <TD><input type="text" name="SCMin"/></TD></TR>
		<TR><TD>Nombre maximum de places en 2nde classe :</TD> <TD><input type="text" name="SCMax"/></TD></TR>
		<TR><TD>Vitesse minimum :</TD> <TD><input type="text" name="VitMin"/></TD></TR>
		<TR><TD>Vitesse maximum :</TD> <TD><input type="text" name="VitMax"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
	
	
<?php
/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");



//affichage des types de trains
$Nom = "%";
$PCMin = -1;
$PCMax = 9999;
$SCMin = -1;
$SCMax = 9999;
$VitMin = 0;
$VitMax = 9999;

if (!empty($_POST['PCMin'])) $PCMin = $_POST['PCMin'];
if (!empty($_POST['PCMax'])) $PCMax = $_POST['PCMax'];
if (!empty($_POST['SCMin'])) $SCMin = $_POST['SCMin'];
if (!empty($_POST['SCMax'])) $SCMax = $_POST['SCMax'];
if (!empty($_POST['VitMin'])) $VitMin = $_POST['VitMin'];
if (!empty($_POST['VitMax'])) $VitMax = $_POST['VitMax'];

if (isset($_POST['Nom'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$Nom = '%'.$_POST['Nom'].'%';
}
	
$query = "SELECT * FROM projet.Type_Train WHERE Nom_Type LIKE '$Nom' AND Nb_Prem>'$PCMin' AND Nb_Prem<'$PCMax' AND Nb_Scnd>'$SCMin' AND Nb_Scnd<'$SCMax' AND Vitesse_Max>'$VitMin' AND Vitesse_Max<'$VitMax'";
$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Type<t/td><td>1ère classes</td><td>2nde classes</td><td>Vitesse max</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
}
echo"</table>";


pg_close($vConn);
?> 

<br><br><br>
<?php } ?>
<a href="gestion_trains_menu.php">Retour page précédente</a>



</body>
</html>