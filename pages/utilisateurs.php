<div class="content" xmlns="http://www.w3.org/1999/html">
	<h1>Les utilisateurs : </h1>
	<p>
		Voici l'ensemble des utilisateurs de Appsense triés par RANG
	</p>
	<a href='ajouterutilisateur' class="btn"><i class="fa fa-user-plus"></i> Ajouter un utilisateur</a>

			<table border="none" width="100%">
				<thead>
					<th>
						<td>NOM</td>
						<td>EMAIL</td>
						<td colspan="2">RANG</td>
					</th>
				<thead>
			<tbody>
				<?php
					include('actions/viewutilisateurs.php');
				?>
			</tbody>
		</table>


</div>