<!DOCTYPE html>
<html>	
<head>
	<title>Gestion points d'intérêt</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion points d'intérêt</c></u></h1>
<br><br>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>

<h2>Ajouter un point d'intérêt</h2>
<TABLE border=0>
	<form method='POST' action='ajout_interet.php'>
		<TR><TD>Nom :</TD> <TD><input type='text' name='Nom'/></TD></TR>
		<TR><TD>Adresse :</TD> <TD><input type='text' name='Adr'/></TD></TR>
		<TR><TD>Code Postal :</TD> <TD><input type='text' name='CP'/></TD></TR>
		<TR><TD>Ville :</TD> <TD><input type='text' name='Ville'/></TD></TR>
		<TR><TD>Gare associée :</TD> <TD><input type="text" name="Gare1"/></TD><TR>
		<TR><TD>Gare associée : (facultatif)</TD> <TD><input type="text" name="Gare2"/></TD><TR>
		<TR><TD>Gare associée : (facultatif)</TD> <TD><input type="text" name="Gare3"/></TD><TR>
		<TR><TD>Type :</TD> <TD><SELECT name='Type' size=1><OPTION>Hotel<OPTION>Agence de taxis</SELECT></TD></TR>
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
<br>

<?php
/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

echo"
<h2>Retirer un point d'intérêt</h2>
";

$query = "SELECT Num, Nom, Ville FROM projet.Point_Interet";
$result = pg_query($vConn, $query);

echo"
<TABLE border=0>
	<form method='POST' action='retrait_interet.php'>
		<TR><TD>Nr :</TD> <TD><SELECT name='Nr'/><OPTION>";
			
		while($row=pg_fetch_row($result))
			echo"<OPTION>$row[0]";
			
		echo"
		</SELECT>
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
<br>
";
?>
	
<h2>Filtrer les points d'intérêt</h2>
<TABLE border=0>
	<form method="POST" action="gestion_interets.php">
		<TR><TD>Nom :</TD> <TD><input type="text" name="Nom"/></TD></TR>
		<TR><TD>Type :</TD> <TD><SELECT name='Type' size=1><OPTION><OPTION>Hotel<OPTION>Agence de taxis</SELECT></TD></TR>
		<TR><TD>Gare :</TD> <TD><input type="text" name="Gare"/></TD><TR>
		<TR><TD>Ville :</TD> <TD><input type="text" name="Ville"/></TD></TR>
		<TR><TD>CP :</TD> <TD><input type="text" name="CP"/></TD></TR>
		<TR><TD>Rue :</TD> <TD><input type="text" name="Adr"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>

<?php
//affichage des gares
$Nom = "%";
$Type = "Agence de taxis' OR Type_Interet = 'Hotel";
$Gare = "%";
$Ville = "%";
$CP = "%";
$Adr = "%";

if (isset($_POST['Nom'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé on bloque la récup du formulaire
	$Nom = '%'.$_POST['Nom'].'%';
}

if (isset($_POST['Type']) && !empty($_POST['Type'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé on bloque la récup du formulaire
	$Type = $_POST['Type'];
}

if (isset($_POST['Gare'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé on bloque la récup du formulaire
	$Gare = '%'.$_POST['Gare'].'%';
}
	
if (isset($_POST['Ville'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé on bloque la récup du formulaire
	$Ville = '%'.$_POST['Ville'].'%';
}

if (isset($_POST['CP'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$CP = $_POST['CP'].'%';
}

if (isset($_POST['Adr'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$Adr = '%'.$_POST['Adr'].'%';
}
	
$query = "SELECT P.Num, P.Nom, P.Type_Interet, G.Gare, P.Ville, P.CP, P.Rue FROM projet.Point_Interet P, projet.Gare_Interet G WHERE P.Num = G.Num_Interet AND Nom LIKE '$Nom' AND Ville LIKE '$Ville' AND Gare LIKE '$Gare' AND CP LIKE '$CP' AND Rue LIKE '$Adr' AND (Type_Interet = '$Type')";
$result = pg_query($vConn, $query);

echo"<table border=1 align='center'>";
echo"<tr><td>Numero</td><td>Nom</td><td>Type</td><td>Gare</td><td>Ville</td><td>CP</td><td>Adresse</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</tr>";
}
echo"</table>";


pg_close($vConn);
}
?> 

<br><br><br>
<a href="menu_gestion.php">Retour page précédente</a>



</body>
</html>