<!DOCTYPE html>
<html>	
<head>
	<title>Gestion Villes</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion villes</c></u></h1>
<br><br>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>

<h2>Ajouter une ville</h2>
<TABLE border=0>
	<form method="POST" action="ajout_ville.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="NomAjout"/></TD></TR>
		<TR><TD>CP :</TD> <TD><input type="text" name="CPAjout"/></TD></TR>
		<TR><TD>Zone horaire :</TD> <TD><input type="text" name="Zone"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
<br>
	
<h2>Retirer une ville</h2>
ATTENTION: Cette fonction est à utiliser avec précaution. Si vous supprimez une ville dans laquelle se trouve une gare, la gare et les points d'intérêt éventuels seront également supprimés!<br>
De plus, vous ne pouvez en aucun cas supprimer une ville de laquelle provient un client répertorié dans la base de donnée.<br>
Il est fortement conseillé de n'utiliser cette fonction que dans le cas d'une erreur de saisie lors de l'ajout d'une ville à la base de données.
<TABLE border=0>
	<form method="POST" action="retrait_ville.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>CP :</TD> <TD><input type="text" name="CP"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
<br>
	
<h2>Filtrer les villes</h2>
<TABLE border=0>
	<form method="POST" action="gestion_villes.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="Nom"/></TD></TR>
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



//affichage des villes
$Nom = "%";
$CP = "%";

if (isset($_POST['Nom'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$Nom = '%'.$_POST['Nom'].'%';
}
	
if (isset($_POST['CP'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$CP = $_POST['CP'].'%';
}
	
$query = "SELECT * FROM projet.Ville WHERE Nom LIKE '$Nom' AND CP LIKE '$CP'";
$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Nom<t/td><td>CP</td><td>Décalage horaire</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
}
echo"</table>";


pg_close($vConn);
?> 

<br><br><br>
<?php } ?>
<a href="menu_gestion.php">Retour page précédente</a>



</body>
</html>