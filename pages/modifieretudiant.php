<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Modification d'un étudiant : </h1>
	<p>
		Vous pouvez modifier un étudiant depuis cette page.
	</p>
		<?php
		//Gestion de la modification
		if(isset($_POST['modif'])){
			$dossier = intval($_GET['id']);
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$datenaiss = $_POST['datenaiss'];
			$email = $_POST['email'];
			$formation = $_POST['formation'];
			$departement = $_POST['departement'];
			$actif = $_POST['actif'];
			$modifEtu = $db->update("UPDATE `appsense`.`etudiants`
SET `nometudiants` = '$nom', `prenometudiants` = '$prenom', `emailetudiants` = '$email', `datenaissanceetudiants` = '$datenaiss', `actifetudiants` = '$actif'
WHERE `etudiants`.`idetudiants` = $dossier AND `etudiants`.`formations_idformations` = $formation AND `etudiants`.`formations_departements_iddepartements` = $departement");
			echo '<p class="text-color-green">Etudiant modifié</p>';
		}
		//Gestion de la suppression
		if(isset($_GET['idDELETE'])){
			$idEtu = intval($_GET['idDELETE']);
			$dellGroupe = $db->delete("DELETE FROM `etudiants_has_groupes` WHERE `etudiants_idetudiants` = $idEtu");
			$dellEtu = $db->delete("DELETE FROM `etudiants` WHERE `idetudiants` = $idEtu");
			header('Location: etudiants');
			exit();
		}

		//Gestion de l'affichage
		if(isset($_GET['id'])){
			$idEtu = intval($_GET['id']);
			$etudiant = $db->query("SELECT * FROM etudiants WHERE idetudiants = $idEtu")->fetch();
			$dpt = $db->query("SELECT * from formations WHERE idformations = $etudiant->formations_idformations")->fetch();
			$formationName = $db->query("SELECT * from departements WHERE iddepartements = $dpt->departements_iddepartements")->fetch();
			$formations = $db->query("
				SELECT * FROM groupes
				LEFT JOIN etudiants_has_groupes ON idgroupes = groupes_idgroupes
				WHERE etudiants_idetudiants = $idEtu")->fetchAll();
		}

		?>

	<form action="modifieretudiant?id=<?= $idEtu ?>" method="post">
		<div class="input">
			<label for="email">Photo de l'étudiant (nul si refus)</label>
			<img src="etc/trombi/<?= $etudiant->photourletudiants?>" alt="<?=$etudiant->nometudiants; ?> <?=$etudiant->prenometudiants; ?>" width="160">
		</div>

		<div class="input">
			<label for="numDossier">Numéro dossier</label>
			<input class="input-text" name="numDossier" type="text" id="numDossier" value="<?= $etudiant->idetudiants; ?>" disabled>
		</div>

		<div class="input">
			<label for="nom">Nom</label>
			<input class="input-text" name="nom" type="text" value="<?= $etudiant->nometudiants; ?>">
		</div>

		<div class="input">
			<label for="prenom">Prénom</label>
			<input class="input-text"	name="prenom"  type="text" value="<?= $etudiant->prenometudiants; ?>">
		</div>

		<div class="input">
			<label for="datenaiss">Date de naissance</label>
			<input class="input-text" type="text" name="datenaiss" value="<?= $etudiant->datenaissanceetudiants; ?>">
		</div>

		<div class="input">
			<label for="email">E-mail Univ-Lorraine</label>
			<input class="input-text" type="text" name="email" value="<?= $etudiant->emailetudiants; ?>">
		</div>

		<div class="input">
			<label for="departement">Département</label>
			<input class="input-text" type="text" value="<?= $formationName->nomdepartements ?>" disabled>
			<input type="hidden" id="idDept" name="departement" value="<?= $formationName->iddepartements ?>">
		</div>

		<div class="input">
			<label for="formation">Formation</label>
			<input class="input-text" type="text" value="<?= $dpt->nomformations ?>" disabled>
			<input type="hidden" id="idForma" name="formation" value="<?= $dpt->idformations ?>">
		</div>

		<div class="input">
			<label for="actif">Etudiants actif (en cours de formation)</label>
			<select name="actif" id="actif">
				<option value="1" <?php if($etudiant->actifetudiants == 1){echo 'selected';} ?>>OUI</option>
				<option value="0" <?php if($etudiant->actifetudiants == 0){echo 'selected';} ?>>NON</option>
			</select>
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
			<?php
			foreach($formations AS $formation){
				echo  "<tr>".
					"<td class='checkbox'><button class='btn btn-red DellGroupeEtu' id='".$formation->idgroupes."'><i class='fa fa-trash'></i></button></td>".
					"<td class='checkbox'>".$formation->idgroupes."</td>".
					"<td>".$formation->nomgroupes."</td>".
					"</tr>";
			}
			?>
			</tbody>
		</table>
		<div>
			<input name="modif" value="MODIFIER" type="submit" class="btn">
		</div>
	</form>
</div>