<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content">
	<h1>Ajouter un étudiant : </h1>
	<p>
		L'ajout d'étudiant est simpliste quelques informations suffisent pour le système.<br>
		Image .JPG uniquement !
	</p>
	<form action="ajouteretudiant2" method="post" enctype="multipart/form-data">
		<div class="input">
			<label for="dossierID">Numéro dossier</label>
			<input class="input-text" type="text" id="dossierID" name="numDossier" placeholder="0123456">
		</div>

		<div class="input">
			<label for="nom">Nom</label>
			<input class="input-text" type="text" id="nom" name="nom" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="prenom">Prénom</label>
			<input class="input-text" type="text" id="prenom" name="prenom" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="datenaiss">Date de naissance</label>
			<input class="input-text" type="text" id="datenaiss" name="datenaiss" placeholder="John Doe">
		</div>

		<div class="input">
			<label for="email">E-mail Univ-Lorraine</label>
			<input class="input-text" type="text" id="email" name="email" placeholder="john.doe@univ-lorraine.fr">
		</div>


		<div class="input">
			<label for="fordpt">Département et formation</label>
			<select id="fordpt" name="fordpt">
				<?php
				$departements = $db->query("SELECT * FROM departements")->fetchAll();
				foreach($departements as $departement){
					echo "<optgroup label='$departement->nomdepartements'>";
					$formations = $db->query("SELECT * FROM formations WHERE departements_iddepartements = $departement->iddepartements")->fetchAll();
					foreach($formations as $formation){
						echo "<option value='$formation->idformations'>$formation->nomformations</option>";
					}
					echo '</optgroup>';
				}
				?>
			</select>

		</div>

		<div class="input">
			<label for="file">Photo de l'étudiant (nul si refus)</label>
			<input class="" type="file" id="file" name="file" placeholder="john.doe@univ-lorraine.fr">
		</div>

		<div>
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> SUIVANT</button>
		</div>
	</form>
</div>