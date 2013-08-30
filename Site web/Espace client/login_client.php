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
$vLogin = $_POST['Login'];
$vMdp = $_POST['Mdp'];

//Check du login et mdp et début de session
$query = "SELECT Mdp, Id FROM projet.Voyageur WHERE Login='$vLogin'";
$result = pg_query($vConn, $query);
$row = pg_fetch_row($result);
$vBddMdp = $row[0];

session_start();

if ($vBddMdp == $vMdp && $vMdp!=NULL){
	$_SESSION['Id'] = $row[1];
	$_SESSION['Login'] = $vLogin;
	$_SESSION['Echec_Id'] = 0;
	header('Location: menu_client.php');
}

else{
	$_SESSION['Echec_Id'] = 1;
	header('Location: accueil_client.php');
}

pg_close($vConn);
?> 
</body>
</html>
