<!DOCTYPE html>
<html>	
<head>
	<title>Deconnection</title>
	<meta charset="utf-8" />
</head>
<body>
	<!--
	<h1><center><u>Espace client</c></u></h1>
	-->
<?php
/* Connexion à la base de données */
$vHost="tuxa.sme.utc";
$vDbname="dbnf17p092";
$vPort="5432";
$vUser="nf17p092";
$vPassword="WOB54woj";
$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

session_start();

unset($_SESSION['Login']);
header('Location: accueil_client.php');

?> 
</body>
</html>