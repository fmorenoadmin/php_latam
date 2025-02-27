<?php
	if(isset($_SESSION)){}else{ session_start(); }
	//-----------------------------------
	$ru0='../';
	//-----------------------------------
	$cls = array(
		"dbs"	=>	'database',
		"cl1"	=>	'usuarios',
	);
	//-----------------------------------
	$dt = array();$json = new stdClass();
	//-----------------------------------
	$_tbl = new stdClass();
	$_tbl->tname = $cls['cl1'];
	$_tbl->tid = 'id_user';
	$_tbl->pid = 0;
	$_tbl->test = true;
	//-----------------------------------
		function index($rut,$rid,$uid,$url,$pag){
			global $cls;
			require($rut.DIRMOR.$cls['dbs'].'.php');
			require_once($rut.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			$data = new stdClass();
			//-----------------------------------
			$data->inf = $_cl1->listar($rid,$uid,$url);
			$data->pass = $_dbs->getRandomCode();
			//-----------------------------------
			return $data;
		}
		function detalle($rut,$rid,$pid){
			global $cls,$_tbl;
			require($rut.DIRMOR.$cls['dbs'].'.php');
			require_once($rut.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			$data = new stdClass();
			//-----------------------------------
			$_tbl->pid = $pid;
			//-----------------------------------
			$data->call = $_cl1->db_get_id(null,$_tbl);
			//-----------------------------------
			return $data;
		}
	//-----------------------------------
	if (isset($_POST['nuevo'])) {
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		$destino= __DIRIMG__."usuarios/";
		//----------------------------------------
		if (isset($_SESSION['user_id'])) {
			require($ru0.DIRMOR.$cls['dbs'].'.php');
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//-----------------------------------
			$_tbl->success = 'add';
			$_tbl->danger = 'no'.$_tbl->success;
			//----------------------------------------
			if (is_uploaded_file($_FILES["foto_u"]["tmp_name"])) {
				$nombfile=$_FILES["foto_u"]["name"];
				$taman=$_FILES["foto_u"]["size"];
				$type=$_FILES["foto_u"]["type"];
				$foto_u=date("YmdHis").str_replace(' ', '_', $nombfile);
				$sub_file = true;
			}else{
				$foto_u='user.png';
				$sub_file = false;
			}
			//-----------------------------------
			$add = array(
				"id_tipo" => base64_decode($_POST['id_tipo']),
				"nombres_u" => $_dbs->custom_escape_string($_POST['nombres_u']),
				"apellidos_u" => $_dbs->custom_escape_string($_POST['apellidos_u']),
				"correo_u" => $_dbs->custom_escape_string($_POST['correo_u']),
				"usuario_u" => $_dbs->custom_escape_string($_POST['usuario_u']),
				"contrasenia_u" => password_hash($_POST['contrasenia_u'], PASSWORD_BCRYPT),
				"telefono_u" => $_dbs->custom_escape_string(str_replace(array(" ", '-', '_'), '', $_POST['telefono_u'])),
				"foto_u" => $foto_u,
				"descrip_u" => str_replace("'", '´', $_POST['descrip_u']),
				"created_at" => date('Y-m-d H:i:s'),
				"id_created" => base64_decode($_POST['uid']),
				"status" => ((isset($_POST['status'])) ? $_POST['status'] : 1),
			);
			//-----------------------------------
			$url = base64_decode($_POST['url']);
			//-----------------------------------
			$resp = $_dbs->db_add($add,$_tbl);
			if ($resp->result) {
				$_SESSION['SMStrue'] = $resp->mensaje;
				if ($sub_file) {
					move_uploaded_file($_FILES["foto_u"]["tmp_name"], $destino.$foto_u);
				}
			}else{
				$_SESSION['SMSfalse'] = $resp->mensaje;
			}
			if (isset($_tbl->test) && $_tbl->test==true) {
				$_SESSION['sql'] = $resp->sql;
			}
			//-----------------------------------
			$_POST = null;
			//-----------------------------------
			header("Location: ".$url);
			exit();
		}else{
			header("Location: ".E403);
			exit();
		}
	}
	if (isset($_POST['editar'])) {
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		$destino= __DIRIMG__."usuarios/";
		//----------------------------------------
		if (isset($_SESSION['user_id'])) {
			require($ru0.DIRMOR.$cls['dbs'].'.php');
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//-----------------------------------
			$_tbl->pid = base64_decode($_POST['pid']);
			$_tbl->success = 'edit';
			$_tbl->danger = 'no'.$_tbl->success;
			//----------------------------------------
			if (is_uploaded_file($_FILES["foto_u"]["tmp_name"])) {
				$nombfile=$_FILES["foto_u"]["name"];
				$taman=$_FILES["foto_u"]["size"];
				$type=$_FILES["foto_u"]["type"];
				$foto_u=date("YmdHis").str_replace(' ', '_', $nombfile);
				$sub_file = true;
			}else{
				$foto_u=$_POST['foto_u_ant'];
				$sub_file = false;
			}
			//-----------------------------------
			if (strlen($_POST['contrasenia_u']) > 5) {
				$pass = password_hash($_POST['contrasenia_u'], PASSWORD_BCRYPT);
			}else{
				$pass = base64_decode($_POST['contrasenia_u_ant']);
			}
			//-----------------------------------
			$edit = array(
				"id_tipo" => base64_decode($_POST['id_tipo']),
				"nombres_u" => $_dbs->custom_escape_string($_POST['nombres_u']),
				"apellidos_u" => $_dbs->custom_escape_string($_POST['apellidos_u']),
				"correo_u" => $_dbs->custom_escape_string($_POST['correo_u']),
				"usuario_u" => $_dbs->custom_escape_string($_POST['usuario_u']),
				"contrasenia_u" => $pass,
				"telefono_u" => $_dbs->custom_escape_string(str_replace(array(" ", '-', '_'), '', $_POST['telefono_u'])),
				"foto_u" => $foto_u,
				"descrip_u" => str_replace("'", '´', $_POST['descrip_u']),
				"updated_at" => date('Y-m-d H:i:s'),
				"id_updated" => base64_decode($_POST['uid']),
				"status" => ((isset($_POST['status'])) ? $_POST['status'] : 1),
			);
			//-----------------------------------
			$url = base64_decode($_POST['url']);
			//-----------------------------------
			$resp = $_dbs->db_edit($edit,$_tbl);
			if ($resp->result) {
				$_SESSION['SMStrue'] = $resp->mensaje;
				if ($sub_file) {
					move_uploaded_file($_FILES["foto_u"]["tmp_name"], $destino.$foto_u);
				}
			}else{
				$_SESSION['SMSfalse'] = $resp->mensaje;
			}
			if (isset($_tbl->test) && $_tbl->test==true) {
				$_SESSION['sql'] = $resp->sql;
			}
			//-----------------------------------
			$_POST = null;
			//-----------------------------------
			header("Location: ".$url);
			exit();
		}else{
			header("Location: ".E403);
			exit();
		}
	}