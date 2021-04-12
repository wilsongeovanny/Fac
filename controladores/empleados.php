<?php
	require_once "../controladores/cargosControladores.php";
	$iEs= new cargosControladores();
	$cEs=$iEs->datos_usuarios_ajax_controlador($_GET['EMPLEADOCODIGO']);
	$datos = array ();
?>
<select id="pers-reg" name="pers-reg" class="form-control">
<option value="0" disabled="disabled">Seleccione</option>			
<?php
	while($row = mysqli_fetch_array ( $cEs ) ){
?>
	<option value="<?php echo $row['EMPLEADOCODIGO']; ?>">
		<?php echo $row['EMPLEADOAPELLIDOS']." ".$row['EMPLEADONOMBRES']; ?>
	</option>
<?php
	} 
										
?>
</select>