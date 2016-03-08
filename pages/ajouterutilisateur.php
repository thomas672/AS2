<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Ajouter un utilisateur : </h1>
	<p>
		L'ajout d'utilisateur est simple, les informations comme le nom et l'adresse e-mail suffiront.<br>
		Un mot de passe aléatoire sera crée et envoyé par e-mail à l'adresse de l'utilisateur.<br>
		L'adresse e-mail sera le seul moyen de connexion à AppSense.
	</p>
	<form action="ajouterutilisateur" method="post">
		<?php
		if(isset($_POST['nom']) AND isset($_POST['email'])){
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$userExiste = $db->query('SELECT COUNT(*) AS count FROM utilisateurs WHERE emailutilisateurs LIKE "%'.$_POST["email"].'%"')->fetch();
				if($userExiste->count >= 1){
					echo "<p class='text-color-red'>E-Mail déjà enregistré.</p>";
				}else{
					$nom = $_POST['nom'];
					$email = $_POST['email'];
					$rang = $_POST['rang'];
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
					$subject = 'Création d\'utilisateur sur AppSense';

					// message
					$message = "
					 <html>
					  <head>
					   <title>Création d'utilisateur sur AppSense</title>
					  </head>
					  <body>
						<h4>AppSense</h4>
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
						$addmodule = $db->insert("INSERT INTO `appsense`.`utilisateurs` (`idutilisateurs`, `nomutilisateurs`, `emailutilisateurs`, `passwordutilisateurs`, `rang_idrang`)
						VALUES (NULL, '$nom', '$email', '$password', '$rang');");
						echo '<p class="text-color-green">Utilisateur ajouté ! Mot de passe généré : '.$generation.'</p>';
					}
				}
			}
			else{
				echo '<p class="text-color-red">E-MAIL invalide</p>';
			}
		}
		?>
		<div class="input">
			<label for="nom">Nom et prénom de l'utilisateur</label>
			<input class="input-text autocompletAjoutmodule" type="text" id="nom" name="nom" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="email">E-mail de l'utilisateur</label>
			<input class="input-text autocompletAjoutmodule" type="text" id="email" name="email" placeholder="john.doe@univ-lorraine.fr">
		</div>
		<div class="input">
			<label for="rang">Rang</label>
			<select name="rang" id="rang">
				<?php
				$rangs = $db->query("SELECT * FROM rang ORDER BY idrang ASC")->fetchAll();
				foreach($rangs as $rang){
					echo "<option value='$rang->idrang'>$rang->nomrang</option>";
				}
				?>
			</select>
		</div>

		<div>
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> AJOUTER</button>
		</div>
	</form>
</div>