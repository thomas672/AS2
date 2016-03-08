<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();

	//Si on visionne ou si l'on modifie
	if(isset($_GET['idUser'])){
		$userInfo = $db->query("SELECT * FROM utilisateurs WHERE idutilisateurs = ".$_GET['idUser'])->fetch();
	}else if(isset($_POST['idUser'])){
		$userInfo = $db->query("SELECT * FROM utilisateurs WHERE idutilisateurs = ".$_POST['idUser'])->fetch();
	}
	else{
		echo 'Erreur';
		die();
	}
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Modifier un utilisateur : </h1>
	<p>
		La modification d'un utilisateur est totale, vous pouvez changer de mot de passe, d'adresse e-mail et de nom.<br>
		La modification entrainera un changement de mot de passe, l'utilisateur sera averti par e-mail de ce
		celui-ci. L'ensemble des identifiants figureront dans l'email de notification.
	</p>
	<form action="modifierutilisateur" method="post">
		<?php
		if(isset($_POST['nom']) AND isset($_POST['idUser'])){
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$nom = $_POST['nom'];
				$email = $_POST['email'];
				$rang = $userInfo->rang_idrang;
				$idUser = $userInfo->idutilisateurs;
				$nb_car = 8;
				$chaine = 'azertyuiopqsdfghjklmwxcvbn123456789';
				$nb_lettres = strlen($chaine) - 1;
				$generation = '';
				for($i=0; $i < $nb_car; $i++)
				{
					$pos = mt_rand(0, $nb_lettres);
					$car = $chaine[$pos];
					$generation .= $car;
				}
				$password=  password_hash($generation, PASSWORD_BCRYPT);

				// Plusieurs destinataires
				$to  = $_POST['email'];

				// Sujet
				$subject = 'IMPORTANT Modification d\'utilisateur sur AppSense';

				// message
				$message = "
				 <html>
				  <head>
				   <title>Modification d'utilisateur sur AppSense</title>
				  </head>
				  <body>
					<h4>AppSense</h4>
					<p>Suite à une modification de votre profil depuis un RANG supperieurs, vos identifiants ont changés.</p>
					<p>Voici les informations utiles pour la connexion au système AppSense.</p>
					<p>
						<ul>
							<li>Votre id de connexion : $email </li>
							<li>Votre mot de passe: $generation</li>
						</ul>
						(Vous pouvez à tous moments changer de mot de passe de l'onglet <i>Mon Profil</i> du site AppSense)
					</p>
				  </body>
				 </html>
			 ";

				// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

				// En-têtes additionnels
				$headers .= "To: $nom <$email>" . "\r\n";
				$headers .= 'From: AppSense(No-reply) < noreply@appsense.com >'. "\r\n";

				// Envoi et verification
				$mailSend = mail($to, $subject, $message, $headers);
				if(!$mailSend) {
					echo "<p class='text-color-red'>Echec d'envoi de l'e-mail.</p>";
				} else {
					$addmodule = $db->update("UPDATE `appsense`.`utilisateurs`
						SET `nomutilisateurs` = '$nom', `emailutilisateurs` = '$email', `passwordutilisateurs` = '$password'
						 WHERE `utilisateurs`.`idutilisateurs` = $idUser
						 AND `utilisateurs`.`rang_idrang` = $rang;");
					echo '<p class="text-color-green">Utilisateur modifié ! Mot de passe généré : '.$generation.'</p>';
				}
			}
			else{
				echo '<p class="text-color-red">E-MAIL invalide</p>';
			}
		}
		?>
		<div class="input">
			<label for="nom">Nom et prénom de l'utilisateur</label>
			<input class="input-text autocompletAjoutmodule" type="text" id="nom" name="nom" placeholder="John Doe" value="<?= $userInfo->nomutilisateurs ?>">
			<input type="hidden" name="idUser" value="<?= $userInfo->idutilisateurs ?>">
		</div>

		<div class="input">
			<label for="email">E-mail de l'utilisateur</label>
			<input class="input-text autocompletAjoutmodule" type="text" id="email" name="email" placeholder="john.doe@univ-lorraine.fr" value="<?= $userInfo->emailutilisateurs ?>">
		</div>

		<div>
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> AJOUTER</button>
		</div>
	</form>
</div>