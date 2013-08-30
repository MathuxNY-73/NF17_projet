<!DOCTYPE html>
<html>	
<head>
	<title>Gestion des trains</title>
	<meta charset="utf-8" />
</head>
<body>

<h1><center><u>Gestion des trains</c></u></h1>
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

$query = "SELECT Nom_Type FROM projet.Type_Train";
$result = pg_query($vConn, $query);

echo"
<h2>Ajouter un nouveau train</h2>
<TABLE border=0>
	<form method='POST' action='ajout_train.php'>
		<TR><TD>Type :</TD> <TD><SELECT name='Type'/>";
		while($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		
echo"
		</SELECT>
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
<br>
";

$query = "SELECT Num FROM projet.Train";
$result = pg_query($vConn, $query);


echo"	
<h2>Retirer un train</h2>
ATTENTION: Cette fonction est à utiliser que dans le cas d'une erreur de saisie lors de l'ajout d'un train à la base de données.<br>
Vous ne pouvez pas retirer un train auquel des trajets sont associés.

<TABLE border=0>
	<form method='POST' action='retrait_train.php'>
		<TR><TD>Nr :</TD> <TD><SELECT name='Nr'/>";
		while($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		
echo"
		</SELECT>
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
<br>
";	
	


$query = "SELECT Nom_Type FROM projet.Type_Train";
$result = pg_query($vConn, $query);

echo"
<h2>Filtrer les trains</h2>
<TABLE border=0>
	<form method='POST' action='gestion_trains.php'>
		<TR><TD>Nr :</TD> <TD><input type='text' name='Nr'/></TD></TR>
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	<form method='POST' action='gestion_trains.php'>
		<TR><TD>Type :</TD> <TD><SELECT name='Type'/><OPTION>";
		while($row = pg_fetch_row($result)) echo"<OPTION>$row[0]";
		
echo"
		</SELECT>
		</TD></TR>
		<TR><TD></TD><TD><input type='submit'/></TD></TR>
	</form>
	</TABLE>
";



//affichage des trains
$Type = "%";

if (!empty($_POST['Nr'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
	$Erreur = 1;
	$Nr = $_POST['Nr'];
	
	$query = "SELECT * FROM projet.Train";
	$result = pg_query($vConn, $query);
	while ($row = pg_fetch_row($result)) if ($row[0]==$Nr) $Erreur = 0;
	
	if ($Erreur) echo"Erreur: le train de numéro $Nr n'est pas dans la base.";
	
	else{
		$query = "SELECT * FROM projet.Train WHERE Num = $Nr ";
		$result = pg_query($vConn, $query);
	}
}

else{
	if (isset($_POST['Type'])){ //si on arrive pour la première fois sur le page et que le formulaire n'a donc pas été envoyé
		$Type = '%'.$_POST['Type'].'%';
	}
		
	$query = "SELECT * FROM projet.Train WHERE Typet LIKE '$Type'";
	$result = pg_query($vConn, $query);
}

echo"<table border=1 align='center'>";
echo"<tr><td>Numero<t/td><td>Type</td></tr>";
while($row = pg_fetch_row($result)){
	echo"<tr><td>$row[0]</td><td>$row[1]</td></tr>";
}
echo"</table>";


pg_close($vConn);
?> 

<br><br><br>
<?php } ?>
<a href="gestion_trains_menu.php">Retour page précédente</a>



</body>
</html>