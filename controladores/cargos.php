<?php
require_once "../core/Consult.php";
$car=$_GET['cargocodigo'];

$consulta=forced::ejecutar_consulta_simple("SELECT * FROM cargo WHERE departamentocodigo='$car'");
$consucar=$consulta->fetchAll();
?>
<select id="car-reg" name="car-reg" onchange="cargarEmp(this)" class="form-control">
	<option value="0" disabled="disabled">Seleccione</option>			
	<?php
	foreach ($consucar as $row) {
		?>
		<option value="<?php echo $row['cargocodigo']; ?>">
			<?php echo $row['cargonombre']; ?>
		</option>
		<?php
	} 

	?>
</select>