<!DOCTYPE html>
<html>	
<head>
	<title>Menu gestion</title>
	<meta charset="utf-8" />
</head>
<body>
	
	<h1><center><u>Espace gestion</c></u></h1>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>	
	
Que voulez vous faire?<br>

<ul>
		<li><a href="gestion_villes.php">Gérer les villes</a></li>
		<li><a href="gestion_gares.php">Gérer les gares</a></li>
		<li><a href="gestion_interets.php">Gérer les points d'intérêt</a></li>
		<li><a href="gestion_trains_menu.php">Gérer les trains</a></li>
		<li><a href="gestion_trajets.php">Gérer les trajets</a></li>
</ul>

<?php } ?>
<a href="../accueil.php">Retour accueil</a>

</body>
</html>