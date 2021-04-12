<?php
require_once "../core/Consult.php";
$dep=$_GET['departamentocodigo'];

$consultar=forced::ejecutar_consulta_simple("SELECT * FROM departemento WHERE empresacodigo='$dep'");
$consudep=$consultar->fetchAll();

?>
<select id="dep-reg" name="dep-reg" onchange="cargarCargo(this)" class="form-control">
	<option value="0" disabled="disabled">Seleccione</option>			
	<?php
	foreach ($consudep as $row) {
		?>
		<option value="<?php echo $row['departamentocodigo']; ?>">
			<?php echo $row['departamentonombre']; ?>
		</option>
		<?php
	} 

	?>
</select>