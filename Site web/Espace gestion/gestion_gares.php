<!DOCTYPE html>
<html>	
<head>
	<title>Gestion Villes</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion gares</c></u></h1>
<br><br>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>

<h2>Ajouter une gare</h2>
<TABLE border=0>
	<form method="POST" action="ajout_gare.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>Adresse :</TD> <TD><input type="text" name="Adr"/></TD></TR>
		<TR><TD>Code Postal :</TD> <TD><input type="text" name="CP"/></TD></TR>
		<TR><TD>Ville :</TD> <TD><input type="text" name="Ville"/></TD></TR>
		<TR><TD>Temps plein minimum :</TD> <TD><input type="text" name="TPM"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
<br>
	
<h2>Retirer une gare</h2>
<TABLE border=0>
	<form method="POST" action="retrait_gare.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>CP :</TD> <TD><input type="text" name="CP"/></TD></TR>
		<TR><TD>Ville :</TD> <TD><input type="text" name="Ville"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
<br>
	
<h2>Filtrer les gares</h2>
<TABLE border=0>
	<form method="POST" action="gestion_gares.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>Ville :</TD> <TD><input type="text" name="Ville"/></TD></TR>
		<TR><TD>CP :</TD> <TD><input type="text" name="CP"/></TD></TR>
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



//affichage des gares
$Nom = "%";
$Ville = "%";
$CP = "%";

if (isset($_POST['Nom'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé on bloque la récup du formulaire
	$Nom = '%'.$_POST['Nom'].'%';
}
	
if (isset($_POST['Ville'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé on bloque la récup du formulaire
	$Ville = '%'.$_POST['Ville'].'%';
}

if (isset($_POST['CP'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$CP = $_POST['CP'].'%';
}
	
$query = "SELECT * FROM projet.Gare WHERE Nom LIKE '$Nom' AND Ville LIKE '$Ville' AND CP LIKE '$CP'";
$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Nom<t/td><td>Ville</td><td>CP</td><td>Adresse</td><td>TP min</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[3]</td><td>$row[2]</td><td>$row[1]</td><td>$row[4]</td></tr>";
}
echo"</table>";


pg_close($vConn);
?> 

<br><br><br>
<?php } ?>
<a href="menu_gestion.php">Retour page précédente</a>



</body>
</html>