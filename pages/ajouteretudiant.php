<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Ajouter un étudiant : </h1>
	<p>
		L'ajout d'étudiant est simpliste quelques informations suffisent pour le système.<br>
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
					$addmodule = $db->insert("INSERT INTO `appsense`.`utilisateurs` (`idutilisateurs`, `nomutilisateurs`, `emailutilisateurs`, `passwordutilisateurs`, `rang_idrang`)
					VALUES (NULL, '$nom', '$email', '$password', '$rang');");
					echo '<p class="text-color-green">Utilisateur ajouté ! Mot de passe généré : '.$generation.'</p>';

				}
			}
			else{
				echo '<p class="text-color-red">E-MAIL invalide</p>';
			}
		}
		?>
		<div class="input">
			<label for="numDossier">Numéro dossier</label>
			<input class="input-text" type="text" id="numDossier" name="numDossier" placeholder="0123456">
		</div>

		<div class="input">
			<label for="nom">Nom</label>
			<input class="input-text" type="text" id="nom" name="nom" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="nom">Prénom</label>
			<input class="input-text" type="text" id="nom" name="nom" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="nom">Date de naissance</label>
			<input class="input-text" type="text" id="nom" name="nom" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="email">E-mail Univ-Lorraine</label>
			<input class="input-text" type="text" id="email" name="email" placeholder="john.doe@univ-lorraine.fr">
		</div>

		<div class="input">
			<label for="departement">Département</label>
			<select name="departement" id="departement" disabled>
				<?php
				$dpts = $db->query("SELECT * FROM departements")->fetchAll();
				foreach($dpts as $dpt){
					echo "<option value='$dpt->iddepartements'>$dpt->nomdepartements</option>";
				}
				?>
			</select>
		</div>

		<div class="input">
			<label for="email">Formation</label>
			<select name="rang" id="rang" disabled>
				<?php
				$dpts = $db->query("SELECT * FROM departements")->fetchAll();
				foreach($dpts as $dpt){
					echo "<option value='$dpt->iddepartements'>$dpt->nomdepartements</option>";
				}
				?>
			</select>
		</div>

		<div class="input">
			<label for="email">Photo de l'étudiant (nul si refus)</label>
			<input class="input-text" type="text" id="email" name="email" placeholder="john.doe@univ-lorraine.fr">
		</div>

		<div class="input">
			<label for="rang">Affilier à un groupe</label>
			<select name="rang" id="rang" disabled>
				<?php
				$rangs = $db->query("SELECT * FROM rang ORDER BY idrang ASC")->fetchAll();
				foreach($rangs as $rang){
					echo "<option value='$rang->idrang'>$rang->nomrang</option>";
				}
				?>
			</select>
			<button class="btn btn-green"><i class="fa fa-plus-circle fa-2x"></i></button>
		</div>
		<table border="none" width="100%">
			<thead>
			<tr>
				<th>IP</th>
				<th>DATE</th>
			</tr>
			</thead>
			<tbody id="groupeEtu">


			</tbody>
		</table>
		<div>
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> AJOUTER L'ETUDIANT</button>
		</div>
	</form>
</div>