<div class="content">
	<div class="vertical-align">
		<?php
			require 'inc/bootstrap.php';
			setlocale(LC_TIME, 'fra_fra');
			Auth::loggedOnly();
		?>
		<div class="box-v-align">
			<p>
				Bienvenue, <strong><?= $_SESSION['auth']->nomutilisateurs ?></strong>,<br>
				Cet espace, commun à l’ensemble des utilisateurs de AppSense, vous propose de nombreux services en fonction de votre rang, notamment :
			<ul>
				<li>L'ajout d'absence dans votre module</li>
				<li>La gestion de votre profil et l'ajout/modification de vos modules</li>
				<li>Une vue direct des quotas d'abstention</li>
				<li>Un trombinoscope complet</li>
			</ul>
			L'accès à AppSense, se fait grâce à votre adresse e-mail UL et d'un mot de passe aléatoire modifiable par la suite.<br>
			Pour les obtenir, consulter le secrétariat de votre département.<br>
			</p>
			<p>
				Nous somme le <?= strftime('%A %d %B %Y'); ?>, pour commencer <button class="menuBtn btn">CLIQUER-ICI</button>
			</p>
		</div>
	</div>
</div>