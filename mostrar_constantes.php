<?php
	if(isset($_SESSION)){ }else{ session_start(); }
	//---------------------------------------------
	$rut = './';
	$action = '';
	$pagina = 'Lista de CONSTANTES DEFINIDAS de PHP';
	//---------------------------------------------
	require_once($rut.'config/constant.php');
	//---------------------------------------------
	// Obtén todas las constantes definidas
	$constantes = get_defined_constants();
	$n=1;
	//---------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Lista de Constantes</title>
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
				<table id="myTable" class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Clave</th>
							<th>Valor</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// Recorre y muestra las claves y valores de las constantes definidas
							foreach ($constantes as $clave => $valor) {
								echo '<tr>';
									echo '<td>'.$n.'</td>';
									echo '<td>'.$clave.'</td>';
									echo '<td>'.$valor.'</td>';
									//echo "Clave: $clave, Valor: $valor <br>";
								echo '</tr>';
								//---------------------------------------------
								$n++;
							}
						?>
					</tbody>
				<table>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
	<script type="text/javascript">
		let table = new DataTable('#myTable');
	</script>
</body>
</html>