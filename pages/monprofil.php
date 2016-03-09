<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();


	$userInfo = $db->query("SELECT * FROM utilisateurs WHERE idutilisateurs = ".$_SESSION['auth']->idutilisateurs)->fetch();

?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Mon compte : </h1>
	<p>
		Vous pouvez modifier votre nom, e-mail et mot de passe depuis le formulaire ci-dessous.
	</p>
	<form action="monprofil" method="post">
		<?php
		if(isset($_POST['nom']) AND isset($_POST['idUser'])){
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$nom = $_POST['nom'];
				$email = $_POST['email'];
				$rang = $userInfo->rang_idrang;
				$idUser = $userInfo->idutilisateurs;
				$nb_car = 8;

				if (!empty($_POST['password']) AND !empty($_POST['passwordc'])) {
					if ($_POST['password'] == $_POST['passwordc']) {
						$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
					} else {
						echo '<p class="text-color-red">Les mots de passe ne correspondent pas.</p>';
					}
				} else {
					$password = $_SESSION['auth']->passwordutilisateurs;
				}


				$addmodule = $db->update("UPDATE `appsense`.`utilisateurs`
						SET `nomutilisateurs` = '$nom', `emailutilisateurs` = '$email', `passwordutilisateurs` = '$password'
						 WHERE `utilisateurs`.`idutilisateurs` = $idUser
						 AND `utilisateurs`.`rang_idrang` = $rang;");

				//On redirige
				echo '<p class="text-color-green">Vous avez mis à jour votre profil, vous allez être deconnecté dans 5 secondes.</p>';
				unset($_SESSION['auth']);
				header("refresh:5;url=index");
			}
			else{
				echo '<p class="text-color-red">E-MAIL invalide</p>';
			}
		}
		else{

		?>
		<div class="input">
			<label for="nom">Nom et prénom de l'utilisateur</label>
			<input class="input-text" type="text" id="nom" name="nom" placeholder="John Doe" value="<?= $userInfo->nomutilisateurs ?>">
			<input type="hidden" name="idUser" value="<?= $userInfo->idutilisateurs ?>">
		</div>

		<div class="input">
			<label for="email">E-mail de l'utilisateur</label>
			<input class="input-text" type="text" id="email" name="email" placeholder="john.doe@univ-lorraine.fr" value="<?= $userInfo->emailutilisateurs ?>">
		</div>

		<div class="input">
			<label for="password">Mot de passe</label>
			<input class="input-text" type="password" id="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
			<input type="hidden" name="idUser" value="<?= $userInfo->idutilisateurs ?>">
		</div>

		<div class="input">
			<label for="passwordc">Confirmation du mot de passe</label>
			<input class="input-text" type="password" id="passwordc" name="passwordc" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
			<input type="hidden" name="idUser" value="<?= $userInfo->idutilisateurs ?>">
		</div>

		<div>
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> AJOUTER</button>
		</div>
		<?php
			$logconnexion = $db->query("SELECT * FROM `log_connexion` WHERE `idlog_connexion` = $userInfo->idutilisateurs LIMIT 0,20")->fetchAll();

		?>
		<table border="none" width="100%">
			<thead>
			<tr>
				<th>IP</th>
				<th>DATE</th>
			</tr>
			</thead>
			<tbody>

		<?php
			foreach($logconnexion AS $log){
				echo "
					<tr>
						<td>$log->iplog_connexion</td>
						<td>$log->datelog_connexion</td>
					</tr>
				";
			}
		}
		?>

			</tbody>
		</table>
	</form>
</div>