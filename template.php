<!--
	/////////////Gestionnaire d'absences de l'IUT de Saint-Dié
	/////////////Design by Jules GIROLD
	/////////////Code Thomas KIEFFER & Jules GIROLD
-->

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="author" content="Thomas KIEFFER & Jules GIROLD" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AppSense</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- On force le mobile a ne pas utiliser le zoom -->
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="57x57" href="etc/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="etc/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="etc/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="etc/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="etc/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="etc/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="etc/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="etc/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="etc/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="etc/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="etc/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="etc/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="etc/favicon/favicon-16x16.png">
    <link rel="manifest" href="etc/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#33333B">
    <meta name="msapplication-TileImage" content="etc/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#33333B">

  </head>
  <body>
    <?php include('inc/header.php'); ?>
    <?php echo $content; ?>

    <!-- EXECUTION de JQUERY-->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- EXECUTION de NOS SCRIPTS -->
    <script src="js/app.js"></script>
    <script src="js/sidebar.js"></script>
  </body>
</html>
