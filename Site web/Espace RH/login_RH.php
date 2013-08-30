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

if ($vMdp == "adminrh" && $vMdp!=NULL){ 
	$_SESSION['RH'] = 1;
	header('Location: menu_RH.php');
}

else{
	$_SESSION['RH'] = 0;
	header('Location: accueil_RH.php');
}

pg_close($vConn);
?> 
</body>
</html>