<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Mes modules : </h1>
	<p>
		Voici l'ensemble de vos modules vous pouvez ajouter ou modifier selon vos besoins. (Si vous n'avez aucun
		module vous ne pouvez pas envoyer de fiche d'appel.
	</p>
	<a href='ajoutermodules' class="btn">Ajouter un/des module(s)</a>
	<form action="mesmodules" method="post">
		<div class="menu-right">
			<button type="submit" class="btn btn-red"><i class="fa fa-trash"></i> SUPPRIMER</button>
			<button type="reset" class="btn btn-blue"><i class="fa fa-undo"></i> DESELCTIONNER</button>
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
					include('actions/mesmodules.php');
				?>
			</tbody>
		</table>
		<div class="menu-right">
			<button type="submit" class="btn btn-red"><i class="fa fa-trash"></i> SUPPRIMER</button>
			<button type="reset" class="btn btn-blue"><i class="fa fa-undo"></i> DESELCTIONNER</button>
		</div>
	</form>

</div>