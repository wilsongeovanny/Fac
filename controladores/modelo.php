<?php
	require_once "../controladores/cargosControladores.php";
	$iEs= new cargosControladores();
	$cEs=$iEs->datos_modelos_ajax_controlador($_GET['MODELOHARDWARECODIGO']);
	$datos = array ();
?>
<select id="marca-reg" name="marca-reg" class="form-control">
<option value="0">SELECCIONE EL MODELO</option>			
<?php
	while($row = mysqli_fetch_array ( $cEs ) ){
?>
	<option value="<?php echo $row['MODELOHARDWARECODIGO']; ?>">
		<?php echo $row['MODELOHARDWARENOMBRE']; ?>
	</option>
<?php
	} 
										
?>
</select>