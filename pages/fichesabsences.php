<?php
require 'inc/bootstrap.php';
$db = App::getDatabase();
App::needSessionStart();
$userId = $_SESSION['auth']->idutilisateurs;
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Les fiches d'absence(s) : </h1>
	<p>
		Voici l'ensemble de vos fiches d'absences, vous pouvez trier par modules
	</p>
	<a href='ajouterfiche' class="btn"><i class="fa fa-list-alt"></i> Créer une fiche d'absence</a>
	<h1>Rechercher un étudiant :</h1>
	<form action="#" method="get">
		<div class="input">
			<label for="dossier">Module</label>
			<select name="changeModulesFiches" id="changeModulesFiches">
				<option value=""></option>
				<?php
					$ueSelects = $db->query("
						SELECT * FROM modules_has_utilisateurs
						LEFT JOIN `ue` ON `idue` = `modules_ue_idue`
						WHERE `utilisateurs_idutilisateurs` = $userId
						GROUP BY `nomue` ORDER BY `idue` ASC
					")->fetchAll();

					foreach($ueSelects AS $ueSelect){
						echo "<optgroup label='$ueSelect->nomue'>";
						$modules = $db->query("
							SELECT * FROM modules
							LEFT JOIN `modules_has_utilisateurs` ON `modules_idmodules` = `idmodules` AND `utilisateurs_idutilisateurs` = $userId
							WHERE `ue_idue` = $ueSelect->idue AND `utilisateurs_idutilisateurs` = $userId
						");

						foreach($modules AS $module){
							echo "<option value='$module->idmodules'>$module->nommodules</option>";
						}

						echo "</optgroup>";
					}
				?>
			</select>
		</div>
	</form>
	<script src="js/autocomplete.js" type=""></script>
			<table border="none" width="100%">
				<thead>
					<tr>
						<th></th>
						<th>DATE</th>
						<th>DUREE</th>
					</tr>
				<thead>
			<tbody id="listFiches">

			</tbody>
		</table>


</div>