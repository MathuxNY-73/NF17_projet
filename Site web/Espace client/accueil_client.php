<!DOCTYPE html>
<html>	
<head>
	<title>Accueil client</title>
	<meta charset="utf-8" />
</head>
<body>
	<h1><center><u>Accueil client</c></u></h1>
	<br><br>
	
	<h2>Vous avez déjà un compte client? Identifiez-vous:</h2>
	
	<?php
		session_start();
		if (isset($_SESSION['Echec_Id'])){
			if($_SESSION['Echec_Id'] == 1) {
				echo "Login ou mot de passe incorrect. Veuillez réessayer!<br>";
				$_SESSION['Echec_Id'] = 0;
			}
			else echo"<br>";
		}
		else echo"<br>";
	?>
	
	<TABLE border=0>
	<form method="POST" action="login_client.php">
		<TR><TD>Login :</TD> <TD><input type="text" name="Login"/></TD></TR>
		<TR><TD>Password :</TD> <TD><input type="password" name="Mdp"/></TD></TR>
		<TR><TD></TD><TD><input type="submit"/></TD></TR>
	</form>
	</TABLE>
	<br><br>
	
	<h2>Vous êtes un nouveau client?</h2>
	<a href="creation_client.html">Créez votre compte client en cliquant ici.</a>

<br><br><br><br><br>
<a href="../accueil.php">RETOUR ACCUEIL</a>
</body>

</html>
