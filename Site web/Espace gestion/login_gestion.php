<!DOCTYPE html>
<html>	
<head>
	<title>Login client</title>
	<meta charset="utf-8" />
</head>
<body>
	
<?php
/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

/* Récupération des variables passées par le fomulaire */
$vMdp = $_POST['Mdp'];

//Check du mdp et début de session
session_start();

if ($vMdp == "admin" && $vMdp!=NULL){ 
	$_SESSION['Gestion'] = 1;
	header('Location: menu_gestion.php');
}

else{
	$_SESSION['Gestion'] = 0;
	header('Location: accueil_gestion.php');
}

pg_close($vConn);
?> 
</body>
</html>