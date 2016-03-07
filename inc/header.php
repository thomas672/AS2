<header>
	<?php
	require_once 'inc/bootstrap.php';
	App::needSessionStart();
	if(isset($_SESSION['auth'])){
		include('menu.php');
	?>
		<div class="menu-left">
			<a href="accueil"><img src="etc/logo_min.svg" width="40" alt="Logo APPSENSE - Lien vers l'accueil"></a>
		</div>
		<div class="menu-right">
			<a href="#" class="menuBtn"><i class="fa fa-bars fa-2x"></i></a>
		</div>
	<?php
	}
	?>
</header>