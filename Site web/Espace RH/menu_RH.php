<!DOCTYPE html>
<html>	
<head>
	<title>Menu RH</title>
	<meta charset="utf-8" />
</head>
<body>
	
	<h1><center><u>Espace gestion</c></u></h1>
<?php
session_start();
if(!isset($_SESSION['RH']) || !$_SESSION['RH']) echo"Vous n'avez pas les droits pour accéder à cette page! Bouh vilain hackeur!<br><br>";
else{
?>	
Que voulez vous faire?<br>

<ul>
		<li><a href="ajout_employe.php">Ajouter un employé</a></li>
		<li><a href="consulter_employes.php">Consulter la liste des employés</a></li>
		<li><a href="statistiques.php">Obtenir des statistiques</a></li>
		<li><a href="xxxxxxxxxx.php">Etc...</a></li>
		<li><a href="xxxxxxxxxx.php">Etc...</a></li>
		
</ul>

<?php } ?>
<a href="../accueil.php">Retour accueil</a>

</body>
</html>