<?php
require_once "../core/Consult.php";
$mod=$_GET['modelohardwarecodigo'];

$consultar=forced::ejecutar_consulta_simple("SELECT * FROM modelo_hardware WHERE marcahardwarecodigo='$mod'");
$consumod=$consultar->fetchAll();

?>
<select id="itemmodelo" name="itemmarca" class="form-control">
<option value="0">SELECCIONE EL MODELO</option>			
<?php
	foreach ($consumod as $row) {
?>
	<option value="<?php echo $row['modelohardwarecodigo']; ?>">
    <?php echo $row['modelohardwarenombre']; ?>
    </option>
<?php
	} 
										
?>
</select>