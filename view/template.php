<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo (COMPANY); ?></title>

	<!-- CSS -->
	<?php include_once('./view/inc/link.php'); ?>


</head>

<body>
	<?php
	$requestAjax = false;
	require_once('./controllers/ViewController.php');
	$viewInstance = new ViewController();
	$view = $viewInstance->getViewController();
	
	//Login o 404 son las vistas por defecto.
	if ($view == "login-view.php" || $view == "404-view.php")
		require_once('./view/' . $view);
	else {
		//Si no, muestra los Nav lateral y bar, y el contenido (la view).
	?>

		<!-- Main container -->
		<main class="full-box main-container">
			<!-- Nav Lateral -->
			<?php include_once('./view/inc/nav-lateral.php'); ?>

			<!-- Page content -->
			<section class="full-box page-content">
				<!-- Nav Bar -->
				<?php
				include_once('./view/inc/nav-bar.php');
				include_once $view;
				?>

			</section>
		</main>

		<!-- SCRIPTS -->
	<?php }
	include_once('./view/inc/scripts.php') ?>
</body>

</html>