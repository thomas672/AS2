<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Ajouter un ou plusieurs module(s) : </h1>
	<h2>
		Filtres de recherche
	</h2>
	<form action="#" method="get">
		<div class="input">
			<label for="email">Code</label>
			<input class="input-text autocompletAjoutmodule" type="text" id="code" name="code" placeholder="Ex: 1KEG2D15">
		</div>
		<div class="input">
			<label for="email">Nom</label>
			<input class="input-text autocompletAjoutmodule" type="text" id="nom" name="nom" placeholder="Ex: Infographie">
		</div>
		<div class="input">
			<label for="dpt">DEPARTEMENT</label>
			<select name="dpt" id="dpt">
				<option value=""></option>
				<?php
				$departements = $db->query("SELECT * FROM departements")->fetchAll();
				foreach($departements as $dpt){
					echo "<option value='$dpt->iddepartements'>$dpt->nomdepartements</option>";
				}
				?>
			</select>
		</div>
		<div class="input">
			<label for="ue">UNITE D'ENSEIGNEMENT</label>
			<select name="ue" id="ue">
				<option value=""></option>
				<?php
				$ues = $db->query("SELECT * FROM ue")->fetchAll();
				foreach($ues as $ue){
					echo "<option value='$ue->idue'>$ue->nomue</option>";
				}
				?>
			</select>
		</div>
		<div class="menu-left">
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> RECHERCHER</button>
		</div>
	</form>
	<form action="ajoutermodules" method="post">
		<div class="menu-right">
			<button type="submit" class="btn btn-green"><i class="fa fa-plus-square"></i> AJOUTER</button>
		</div>
			<table border="none" width="100%">
				<thead>
					<th>
						<td>CODE</td>
						<td>NOM</td>
						<td>DPT</td>
					</th>
				<thead>
			<tbody>
				<?php
					include('actions/ajoutermodules.php');
				?>
			</tbody>
		</table>
		<div class="menu-right">
			<button type="submit" class="btn btn-green"><i class="fa fa-plus-square"></i> AJOUTER</button>
		</div>
	</form>

</div>