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
$vNom = $_POST['Nom'];
$vPrenom = $_POST['Prenom'];
$vTel = $_POST['Tel'];
$vRue = $_POST['Rue'];
$vCP = $_POST['CP'];
$vVille = $_POST['Ville'];
$vLogin = $_POST['Login'];
$vMdp = $_POST['Mdp'];

//faire un mutex sur la table personne ici pour éviter de récupérer un faux ID à insérer dans Voyageur
$query = "INSERT INTO projet.personne VALUES (DEFAULT, '$vNom', '$vPrenom', '$vTel', '$vRue', '$vCP', '$vVille')";
$result = pg_query($vConn, $query);

$query2 = "SELECT Id FROM projet.personne";
$result2 = pg_query($vConn, $query2);
while ( $row = pg_fetch_row($result2)){
	$vId = $row[0];
} //récupération de l'Id correspondant à la personne qu'on vient de créer pour bien la référencer dans la table voyageur

$query3 = "INSERT INTO projet.voyageur VALUES ('$vId', '$vLogin', '$vMdp')";
$result3 = pg_query($vConn, $query3);

pg_close($vConn);
?> 
Votre compte client a été créé. Vous pouvez maintenant utiliser vos identifiants pour naviguer sur le site.<br><br>

<a href="accueil_client.php">Retour à la page d'accueil client</a>



</body>
</html>