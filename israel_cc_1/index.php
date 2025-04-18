<?php
	if(isset($_SESSION)){ }else{ session_start(); }
	//---------------------------------------------
	$rut = '../';
	$action = '';
	$pagina = 'Prevas JSON';
	//---------------------------------------------
	require_once($rut.'config/constant.php');
	//---------------------------------------------
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Prevas JSON</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 pt-2 mt-2">
				<br>
			</div>
			<div class="col-sm-4">
				<a href="<?= $rut; ?>" class="btn btn-danger">Regresar</a>
			</div>
			<div class="col-sm-4 text-center">
				<h3 class="title text-center"><?= $pagina; ?></h3>
			</div>
			<div class="col-sm-4">
			</div>
			<div class="col-sm-12 pt-2 mt-2">
				<br>
			</div>
			<div class="col-sm-12">
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
</body>
</html>