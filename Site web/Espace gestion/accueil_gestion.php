<!DOCTYPE html>
<html>	
<head>
	<title>Accueil gestion</title>
	<meta charset="utf-8" />
</head>
<body>
	<h1><center><u>Accueil gestion</c></u></h1>
	<br><br>
	
	<h2>Veuillez entrer le mot de passe gestion</h2>
	
	<?php
		session_start();
		if (isset($_SESSION['Gestion'])){
			if($_SESSION['Gestion'] == 0) {
				echo "Mot de passe incorrect.<br>";
			}
			else echo"<br>";
		}
		else echo"<br>";
		
	?>
	
	<TABLE border=0>
	<form method="POST" action="login_gestion.php">
		<TR><TD>Password :</TD> <TD><input type="password" name="Mdp"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
	<br><br>

<br><br><br><br><br>
<a href="../accueil.php">RETOUR ACCUEIL</a>
</body>

</html>
