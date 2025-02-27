<?php
	/**
	 * 
	 */
	class mh_orders extends database
	{
		private $table	='mh_orders';
		private $table0	='';
		private $table1	='';
		private $table2	='';
		private $actio	='mh_orders.php';
		private $detail	='detalle/?p=';
		private $tid	="id_order";
		private $tid1	="";
		private $tid2	="";
		//----------------------------------
			function cantidad($rid){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$inf = 0;
				//---------------------------------------------------------
				$sql = "SELECT ".$this->tid." FROM ".$this->table." WHERE ";
					switch ($rid) {
						case 1:
						case 2:
							$sql .= " status<>2 ";
						break;
						default:
							$sql .= " status=1 ";
						break;
					}
				$sql .= " ;";
				$res = $this->db_exec($sql,false);
				//--------------------------------
				$inf = $res->cant;
				//--------------------------------
				$fc_close($this->connect());
				return $inf;
			}
		//----------------------------------
			function dtl($campo){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$inf=null;
				//---------------------------------------------------------
				$sql="SELECT ".$campo." FROM ".$this->table." WHERE ";
					switch ($rid) {
						case 1:
						case 2:
							$sql .= " status<>2 ";
						break;
						default:
							$sql .= " status=1 ";
						break;
					}
				$sql .= " ORDER BY ".$campo." ASC ;";
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)){
						$inf.='<option value="'.$row[$campo].'" />';
					}
					//--------------------------------
					$fc_fre_r($res->res);
				}else{
					$inf.='<option value="No se ejecutó la consulta. Error: '.$res->error.'">';
				}
				//--------------------------------
				$fc_close($this->connect());
				return $inf;
			}
			function cbo($rid){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$inf="";
				//--------------------------------
				$inf.='<option value="'.base64_encode(0).'">Seleccione la Orden:</option>';
				//--------------------------------
				$sql = "SELECT * FROM ".$this->table." WHERE status=1 ;";
				//--------------------------------
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)){
						$inf .= '<option value="'.base64_encode($row[$this->tid]).'">'.$row['nombre'].'</option>';
					}
					//--------------------------------
					$fc_fre_r($res->res);
				}else{
					$inf .= '<option value="'.base64_encode(0).'">No se obtivo la información. Error: '.$res->error.'</option>';
				}
				//--------------------------------
				$fc_close($this->connect());
				return $inf;
			}
		//----------------------------------
			function listar($rid,$uid,$url,$test=false){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass();
				$inf = null; $n=1; $cant = 10; $data->error = null;
				//--------------------------------
				$inf.='<thead style="width: 100%;">';
					$inf.='<tr>';
						$inf.='<th><i class="fas fa-list-ol"></i></th>';
						$inf.='<th><i class="fas fa-id-badge"></i></th>';
						$inf.='<th>Foto</th>';
						$inf.='<th>Tipo de Usuario</th>';
						$inf.='<th>Nombre</th>';
						$inf.='<th>Correo</th>';
						$inf.='<th>Usuario</th>';
						$inf.='<th>Teléfono</th>';
						$inf.='<th>Creado</th>';
						$inf.='<th><i class="fas fa-users-cog"></i></th>';
					$inf.='</tr>';
				$inf.='</thead>';
				$inf.='<tbody style="width: 100%;">';
					$sql = "SELECT o.reference AS ref, c.apellidos, c.nombre AS nombre, o.total_paid_tax_excl AS total_sin, o.total_paid_tax_incl AS total_con FROM mh_orders o INNER JOIN mh_customer c ON o.id_customer=c.id_customer WHERE o.date_add BETWEEN '2025-01-01' AND '".date('Y-m-d')."';";
					//--------------------------------
					$res = $this->db_exec($sql);
					if ($res->result==true && $res->cant > 0) {
						$data->result = true;
						$data->mensaje = 'Registros encontrados.';
						//--------------------------------
						while ($row = $fc_assoc($res->res)) {
							$status = $row['status'];
							//-------------------------------------
							$datos2 = base64_encode($row[$this->tid]).'||'.base64_encode(utf8_decode($row['nombre_comp']));
							//-------------------------------------
							$inf.='<tr>';
								$inf.='<td>'.$n.'</td>';
								$inf.='<td>'.$row[$this->tid].'</td>';
								$inf.='<td>';
									if (strlen($row['foto_u']) > 5) {
										$inf.='<img style="max-width: 100px; max-height: 100px;" src="'.IMG.'mh_orders/'.$row['foto_u'].'" />';
									}else{
										$inf.='No imagen';
									}
								$inf.='</td>';
								$inf.='<td>'.$row['nombre_t'].'</td>';
								$inf.='<td>'.$row['nombre_comp'].'</td>';
								$inf.='<td>'.$row['correo_u'].'</td>';
								$inf.='<td>'.$row['usuario_u'].'</td>';
								$inf.='<td><a href="https://wa.me/'.$row['telefono_u'].'" target="_blank">'.$row['telefono_u'].'</a></td>';
								$inf.='<td>'.$row['created_at'].'</td>';
								$inf.='<td>';
									$inf .= '<a href="'.$this->detail.base64_encode($row[$this->tid]).'" target="_blank" class="btn btn-xs btn-warning" >';
										$inf .= '<i class="fa fa-edit" ></i>';
									$inf .= '</a> ';
									if ($rid==1 || $rid==2 || $rid==4) {
										switch ($status) {
											case 1:
												$inf.='<a href="'.ACTI.$this->actio.'?pid='.base64_encode($row[$this->tid]).'&meth=des&url='.base64_encode($url).'" class="btn btn-xs btn-block btn-outline-success btn-flat"><i class="fas fa-check-circle"></i></a> ';
											break;
											case 2:
												$inf.='<a href="'.ACTI.$this->actio.'?pid='.base64_encode($row[$this->tid]).'&meth=act&url='.base64_encode($url).'" class="btn btn-xs btn-block btn-outline-danger btn-flat"><i class="fas fa-times-circle"></i></a> ';
											break;
											default:
												$inf.='<a href="'.ACTI.$this->actio.'?pid='.base64_encode($row[$this->tid]).'&meth=act&url='.base64_encode($url).'" class="btn btn-xs btn-block btn-outline-warning btn-flat"><i class="fas fa-ban"></i></a> ';
											break;
										}
									}else{
										switch ($status) {
											case 1:
												$inf.='<span class="btn btn-xs btn-block btn-outline-success btn-flat"><i class="fas fa-check-circle"></i></span> ';
											break;
											case 2:
												$inf.='<span class="btn btn-xs btn-block btn-outline-danger btn-flat"><i class="fas fa-times-circle"></i></span> ';
											break;
											default:
												$inf.='<span class="btn btn-xs btn-block btn-outline-warning btn-flat"><i class="fas fa-ban"></i></span> ';
											break;
										}
									}
									if ($rid==1 || $rid==2) {
										$inf .= '<button type="button" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar" onclick="eliminar('."'".$datos2."'".');" >';
											$inf .= '<i class="fas fa-trash"></i>';
										$inf .= '</button>';
									}
								$inf.='</td>';
							$inf.='</tr>';
							//---------------------------------
							$n++;
						}
						//--------------------------------
						$fc_fre_r($res->res);
					}else{
						if ($res->cant == 0) {
							$data->result = false;
							$data->mensaje = 'No hay registros.';
							$inf .= '';
						}else{
							$data->result = false;
							$data->mensaje = 'No se ejecutó la consulta. Error: '.$res->error;
							$inf .= '';
						}
					}
				$inf.='</tbody>';
				//--------------------------------
				$data->inf = $inf;
				$data->cant = $res->cant;
				if (isset($test) && $test==true) {
					$data->sql = $sql;
				}
				//--------------------------------
				$fc_close($this->connect());
				return $data;
			}
		//---------------------------------------
			function exportar($tip){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$inf=null;$n=1;$cant=10;
				//-------------------------------------
				$inf.='<thead>';
					$inf.='<tr>';
						$inf.='<th>#</th>';
						$inf.='<th>Foto</th>';
						$inf.='<th>Tipo de Usuario</th>';
						$inf.='<th>Nombre</th>';
						$inf.='<th>Correo</th>';
						$inf.='<th>Usuario</th>';
						$inf.='<th>Teléfono</th>';
						$inf.='<th>Creado</th>';
						$inf.='<th>Editado</th>';
						$inf.='<th>Eliminado</th>';
						$inf.='<th>Estado</th>';
						$inf.='<th>Imagen</th>';
					$inf.='</tr>';
				$inf.='</thead>';
				$inf.='<tbody>';
					$sql = "SELECT u.*, CONCAT(u.nombres_u, ' ', u.apellidos_u) AS nombre_comp, tu.nombre_t FROM ".$this->table." u INNER JOIN ".$this->table1." tu ON u.".$this->tid1."=tu.".$this->tid1." WHERE u.status=1 ;";
					$res = $this->db_exec($sql);
					if ($res->result==true && $res->cant > 0) {
						while ($row = $fc_assoc($res->res)) {
							$inf.='<tr>';
								$inf.='<td>'.$n.'</td>';
								$inf.='<td>';
									$inf.='No imagen';
								$inf.='</td>';
								$inf.='<td>'.$row['nombre_t'].'</td>';
								$inf.='<td>'.$row['nombre_comp'].'</td>';
								$inf.='<td>'.$row['correo_u'].'</td>';
								$inf.='<td>'.$row['usuario_u'].'</td>';
								$inf.='<td><a href="https://wa.me/'.$row['telefono_u'].'" target="_blank">'.$row['telefono_u'].'</a></td>';
								$inf.='<td>'.$row['created_at'].'</td>';
								$inf.='<td>'.$row['updated_at'].'</td>';
								$inf.='<td>'.$row['drop_at'].'</td>';
								$inf.='<td>';
									switch ($row['status']) {
										case 0:
											$inf.='Inactivo';
										break;
										case 1:
											$inf.='Activo';
										break;
										case 2:
											$inf.='Eliminado';
										break;
									}
								$inf.='</td>';
							$inf.='</tr>';
							//-------------------------------------
							$n++;
						}
						$fc_fre_r($res->res);//liberar memoria del resultado
					}else{
						if ($res->cant == 0) {
							$inf.='';
						}else{
							$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-danger">Error: '.$res->error.'</div></td></tr>';
						}
					}
				$inf.='</tbody>';
				//-------------------------------------
				$fc_close($this->connect());
				return $inf;
			}
		//---------------------------------------
	}