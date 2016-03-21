<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content">
	<h1>Rapport de module : </h1>
	<p>
		Visualiser en temps réel les absences du module.<br>
		Vous pouvez générer un PDF <a href="actions/modulerapportPDF.php?id=" class="btn btn-green"><i class="fa fa-file-pdf-o"></i> CREER UN PDF</a>
	</p>
	<form>
		<?php
			$moduleInfo = $db->query("SELECT * FROM modules WHERE idmodules = ".intval($_GET['id']))->fetch();
		?>
		<div class="input">
			<label for="dossierID">CODE module</label>
			<input class="input-text" type="text" value="<?= $moduleInfo->codemodules ?>" disabled>
		</div>

		<div class="input">
			<label for="nom">NOM module</label>
			<input class="input-text" type="text" value="<?= $moduleInfo->nommodules ?>" disabled>
		</div>

		<h2>Absence(s) non justifiée(s)</h2>
		<table border="none" width="100%">
			<thead>
			<tr>
				<th>NOM</th>
				<th>PRENOM</th>
				<th>PHOTO</th>
				<th>DATE</th>
				<th>GROUPE</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$listAbs = $db->query("SELECT * FROM absences_has_etudiants
					LEFT JOIN `etudiants` ON `idetudiants` = `idetudiants_etudiant`
					LEFT JOIN `absences` ON `idabsences` = `idAbsence_absence`
					LEFT JOIN `groupes` ON `idgroupes` = `idgroupe_absences`
				WHERE `excuse` = 0 AND `idmodules_absences` = ".intval($_GET['id']))->fetchAll();

				foreach($listAbs AS $abs){
					echo
						"<tr>".
							"<td>".$abs->nometudiants."</td>".
							"<td>".$abs->prenometudiants."</td>".
							"<td class='centeredTd'><img width='60' src='etc/trombi/".$abs->photourletudiants."'></td>".
							"<td>".$abs->dateabsences."</td>".
							"<td>".$abs->nomgroupes."</td>".
						"</tr>";
				}
			?>
			</tbody>
		</table>

		<h2>Absence(s) justifiée(s)</h2>
		<table border="none" width="100%">
			<thead>
			<tr>
				<th>NOM</th>
				<th>PRENOM</th>
				<th>PHOTO</th>
				<th>DATE</th>
				<th>GROUPE</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$listAbs = $db->query("SELECT * FROM absences_has_etudiants
					LEFT JOIN `etudiants` ON `idetudiants` = `idetudiants_etudiant`
					LEFT JOIN `absences` ON `idabsences` = `idAbsence_absence`
					LEFT JOIN `groupes` ON `idgroupes` = `idgroupe_absences`
				WHERE `excuse` = 1 AND `idmodules_absences` = ".intval($_GET['id']))->fetchAll();

			foreach($listAbs AS $abs){
				echo
					"<tr>".
					"<td>".$abs->nometudiants."</td>".
					"<td>".$abs->prenometudiants."</td>".
					"<td class='centeredTd'><img width='60' src='etc/trombi/".$abs->photourletudiants."'></td>".
					"<td>".$abs->dateabsences."</td>".
					"<td>".$abs->nomgroupes."</td>".
					"</tr>";
			}
			?>
			</tbody>
		</table>

		<h2>Retard(s)</h2>
		<table border="none" width="100%">
			<thead>
			<tr>
				<th>NOM</th>
				<th>PRENOM</th>
				<th>PHOTO</th>
				<th>DATE</th>
				<th>GROUPE</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$listAbs = $db->query("SELECT * FROM absences_has_etudiants
					LEFT JOIN `etudiants` ON `idetudiants` = `idetudiants_etudiant`
					LEFT JOIN `absences` ON `idabsences` = `idAbsence_absence`
					LEFT JOIN `groupes` ON `idgroupes` = `idgroupe_absences`
				WHERE `excuse` = 2 AND `idmodules_absences` = ".intval($_GET['id']))->fetchAll();

			foreach($listAbs AS $abs){
				echo
					"<tr>".
					"<td>".$abs->nometudiants."</td>".
					"<td>".$abs->prenometudiants."</td>".
					"<td class='centeredTd'><img width='60' src='etc/trombi/".$abs->photourletudiants."'></td>".
					"<td>".$abs->dateabsences."</td>".
					"<td>".$abs->nomgroupes."</td>".
					"</tr>";
			}
			?>
			</tbody>
		</table>

	</form>
</div>