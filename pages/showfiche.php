<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content">
	<h1>Fiche absence : </h1>
	<form>
		<?php
			$ficheAbs = $db->query("SELECT * FROM absences
				LEFT JOIN `ue` ON `idue` = `idue_absences`
				LEFT JOIN `modules` ON `idmodules` = `idmodules_absences`
				LEFT JOIN `groupes` ON `idgroupes` = `idgroupe_absences`
			WHERE idabsences = ".intval($_GET['id']))->fetch();
		?>
		<div class="input">
			<label for="dossierID">DATE</label>
			<input class="input-text" type="text" value="<?= $ficheAbs->dateabsences ?>" disabled>
			<input class="input-text" type="hidden" id="idAbsence" value="<?= $ficheAbs->idabsences ?>" disabled>
		</div>

		<div class="input">
			<label for="nom">NOM module</label>
			<input class="input-text" type="text" value="<?= $ficheAbs->nommodules ?>" disabled>
		</div>

		<div class="input">
			<label for="nom">UE module</label>
			<input class="input-text" type="text" value="<?= $ficheAbs->nomue ?>" disabled>
		</div>

		<div class="input">
			<label for="nom">GROUPE module</label>
			<input class="input-text" type="text" value="<?= $ficheAbs->nomgroupes ?>" disabled>
		</div>

		<h2>Absence(s)</h2>
		<table border="none" width="100%">
			<thead>
			<tr>
				<th>NOM</th>
				<th>PRENOM</th>
				<th>PHOTO</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
				$listAbs = $db->query("SELECT * FROM absences_has_etudiants
					LEFT JOIN `etudiants` ON `idetudiants` = `idetudiants_etudiant`
				WHERE `idAbsence_absence` = ".intval($_GET['id']))->fetchAll();

				foreach($listAbs AS $abs){
					echo
					"<tr>".
							"<td>".$abs->nometudiants."</td>".
							"<td>".$abs->prenometudiants."</td>".
							"<td class='centeredTd'><img width='60' src='etc/trombi/".$abs->photourletudiants."'></td>".
							"<td>";

					?>
								<select name='excuseVal' class='changeExcuse' id='<?= $abs->idetudiants ?>'>
									<option <?php if($abs->excuse == 0){echo 'selected';} ?> value='0'>Non excusé</option>
									<option <?php if($abs->excuse == 1){echo 'selected';} ?> value='1'>Excusé</option>
									<option <?php if($abs->excuse == 2){echo 'selected';} ?> value='2'>Retard</option>
								</select>
					<?php
						echo "</td>".
					"</tr>";
				}
			?>
			</tbody>
		</table>

	</form>
</div>