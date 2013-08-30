<!DOCTYPE html>
<html>	
<head>
	<title>Menu gestion trains</title>
	<meta charset="utf-8" />
</head>
<body>
	
	<h1><center><u>Menu gestion trains</c></u></h1>

<?php
session_start();
if(!isset($_SESSION['Gestion']) || !$_SESSION['Gestion']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>	
	
Que voulez vous faire?<br>

<ul>
		<li><a href="gestion_types_trains.php">Gérer les types de train</a></li>
		<li><a href="gestion_trains.php">Gérer les trains</a></li>
</ul>

<?php } ?>
<a href="menu_gestion.php">Retour page précédente</a>

</body>
</html>