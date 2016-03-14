<?php
require 'inc/bootstrap.php';
App::needSessionStart();
$db = App::getDatabase();
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Ajouter un étudiant : </h1>
	<p>
		Ajouter l'etudiant à un ou plusieurs groupes.<br>
	</p>
	<?php
	if(isset($_POST['nom']) AND isset($_POST['email'])){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$etuExist = $db->query('SELECT COUNT(*) AS count FROM etudiants WHERE idetudiants LIKE "%'.$_POST["numDossier"].'%"')->fetch();
			if($etuExist->count >= 1){
				echo "<p class='text-color-red'>Etudiant déjà enregistré.</p>";
			}else{
				$dossier = $_POST['numDossier'];
				$nom = $_POST['nom'];
				$prenom = $_POST['prenom'];
				$datenaiss = $_POST['datenaiss'];
				$email = $_POST['email'];
				$formation = $_POST['fordpt'];
				$dpt = $db->query("SELECT * from formations WHERE idformations = $formation")->fetch();
				$dptId = $dpt->departements_iddepartements;
				$formationName = $db->query("SELECT * from departements WHERE iddepartements = $dptId")->fetch();

				//Envoi d'image
				$target_dir = "etc/trombi/";
				$target_file = $target_dir . $dossier;
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file.'.'.$imageFileType)) {
					$imgName = $dossier.'.'.$imageFileType;
				} else {
					$imgName = 'nopic.jpg';
				}

				$addmodule = $db->insert("INSERT INTO `appsense`.`etudiants` (`idetudiants`, `nometudiants`, `prenometudiants`, `emailetudiants`, `datenaissanceetudiants`, `photourletudiants`, `formations_idformations`, `actifetudiants`, `formations_departements_iddepartements`)
						VALUES ('$dossier', '$nom', '$prenom', '$email', '$datenaiss', '$imgName', $formation, 1, $dptId)");

			}
		}
		else{
			echo '<p class="text-color-red">E-MAIL Univ-Lorraine invalide</p>';
		}
	}
	?>
	<div class="input">
		<label for="numDossier">Numéro dossier</label>
		<input type="text" id="numDossier" value="<?= $_POST['numDossier']; ?>" disabled>
	</div>

	<div class="input">
		<label for="nom">Nom</label>
		<input type="text" value="<?= $_POST['nom']; ?>" disabled>
	</div>

	<div class="input">
		<label for="prenom">Prénom</label>
		<input type="text" value="<?= $_POST['prenom']; ?>" disabled>
	</div>

	<div class="input">
		<label for="datenaiss">Date de naissance</label>
		<input type="text" value="<?= $_POST['datenaiss']; ?>" disabled>
	</div>

	<div class="input">
		<label for="email">E-mail Univ-Lorraine</label>
		<input type="text" value="<?= $_POST['email']; ?>" disabled>
	</div>

	<div class="input">
		<label for="departement">Département</label>
		<input type="text" value="<?= $formationName->nomdepartements ?>" disabled>
		<input type="hidden" id="idDept" value="<?= $formationName->iddepartements ?>">
	</div>

	<div class="input">
		<label for="email">Formation</label>
		<input type="text" value="<?= $dpt->nomformations ?>" disabled>
		<input type="hidden" id="idForma" value="<?= $dpt->idformations ?>">
	</div>

	<div class="input">
		<label for="email">Photo de l'étudiant (nul si refus)</label>
		<img src="etc/trombi/<?= $imgName?>" alt="<?= $_POST['nom']; ?> <?= $_POST['prenom']; ?>" width="60">
	</div>

	<div class="input">
		<label for="groupe">Affilier à un groupe</label>
		<select name="groupe" id="groupe">
			<?php
			$groupes = $db->query("SELECT * FROM groupes ORDER BY idgroupes ASC")->fetchAll();
			foreach($groupes as $groupe){
				echo "<option value='$groupe->idgroupes'>$groupe->nomgroupes</option>";
			}
			?>
		</select>
		<button class="btn btn-green" id="addGroupe"><i class="fa fa-plus-circle fa-2x"></i></button>
	</div>
	<table border="none" width="100%">
		<thead>
		<tr>
			<th></th>
			<th>ID</th>
			<th>NOM GROUPE</th>
		</tr>
		</thead>
		<tbody id="groupeEtu">

		</tbody>
	</table>
	<div>
		<a class="btn" href="etudiants"><i class="fa fa-plus-square"></i> FINIR</a>
	</div>
</div>