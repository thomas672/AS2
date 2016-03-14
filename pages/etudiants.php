<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Les étudiants : </h1>
	<p>
		Voici l'ensemble des étudiants de l'IUT de Saint-Dié-des-Vosges.
	</p>
	<a href='ajouteretudiant' class="btn"><i class="fa fa-user-plus"></i> Ajouter un étudiant</a>
	<h1>Rechercher un étudiant :</h1>
	<form action="#" method="get">
		<div class="input">
			<label for="dossier">N° DOSSIER</label>
			<input class="input-text autocompletEtu" type="text" id="dossier" name="dossier" placeholder="Ex: 1KEG2D15">
		</div>
		<div class="input">
			<label for="nom">NOM</label>
			<input class="input-text autocompletEtu" type="text" id="nom" name="nom" placeholder="John">
		</div>
		<div class="input">
			<label for="prenom">PRENOM</label>
			<input class="input-text autocompletEtu" type="text" id="prenom" name="prenom" placeholder="Doe">
		</div>
	</form>
	<script src="js/autocomplete.js" type=""></script>
			<table border="none" width="100%">
				<thead>
					<tr>
						<th></th>
						<th>DOSSIER</th>
						<th>NOM</th>
						<th>PRENOM</th>
						<th>PHOTO</th>
					</tr>
				<thead>
			<tbody id="listEtu">
				<?php
					require 'inc/bootstrap.php';
					$db = App::getDatabase();
					$allEtu = $db->query("SELECT * FROM etudiants WHERE actifetudiants = 1 ORDER BY nometudiants ASC")->fetchAll();
					foreach($allEtu AS $etu){
						echo "<tr>
							<td class='centeredTd'><a href='modifieretudiant?id=$etu->idetudiants' class='btn btn-blue'><i class=\"fa fa-pencil\"></i></a> <a href='modifieretudiant?idDELETE=$etu->idetudiants' class='btn btn-red'><i class=\"fa fa-trash-o\"></i></a></td>
							<td class='centeredTd'>$etu->idetudiants</td>
							<td>$etu->nometudiants</td>
							<td>$etu->prenometudiants</td>
							<td class='centeredTd'><img src='etc/trombi/$etu->photourletudiants' width='40'></td>
						</tr>";
					}
				?>
			</tbody>
		</table>


</div>