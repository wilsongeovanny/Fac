<?php
require_once "../core/Consult.php";
$mod=$_GET['marcahardwarecodigo'];

$consultar=forced::ejecutar_consulta_simple("SELECT * FROM marca_hardware WHERE tipohardwarecodigo='$mod'");
$consumod=$consultar->fetchAll();

?>
<select id="itemmarca" name="itemmarca" onchange="cargarModelo(this)" class="form-control">
<option value="0">SELECCIONE LA MARCA</option>			
<?php
	foreach ($consumod as $row) {
?>
	<option value="<?php echo $row['marcahardwarecodigo']; ?>">
    <?php echo $row['marcahardwarenombre']; ?>
    </option>
<?php
	} 
										
?>
</select>