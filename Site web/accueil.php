<!DOCTYPE html>
<html>	
<head>
	<title>Voyages'NF17</title>
	<meta charset="utf-8" />
</head>
<body>
	<?php
		session_start();
		unset($_SESSION['Gestion']);
		unset($_SESSION['RH']);
		unset($_SESSION['Billettique']);
	?>
	
	<h1><center><u>Accueil</u></c></h1>
	<br><br>
	<center><a href="Espace client/accueil_client.php"><img src="Images/client.jpg" width="400"></a>
	<br><br>
	<a href="Espace gestion/accueil_gestion.php"><img src="Images/gestion.jpg" width="400"></a>
	<br><br>
	<a href="Espace RH/accueil_RH.php"><img src="Images/rh.jpg" width="400"></a>
	<br><br>
	<a href="Espace billettique/accueil_billettique.php"><img src="Images/billettique.jpg" width="400"></a></center>
</body>

</html>
