<!--<script type="text/javascript">
var elementoPaises = document.getElementById('paises')
var paisesElegidos = []

function elegirPais(element){
    if (element.checked) {
        paisesElegidos.push(element.value)
    }else{
        paisesElegidos.splice( paisesElegidos.indexOf( element.value ), 1 )
    }
    elementoPaises.innerHTML = paisesElegidos.join(', ')
}
</script>-->




<script type="text/javascript">
    var elementoPaises1 = document.getElementById('paises')
    var paisesElegidos = []


    function elegirPais(element){
        if (element.checked) {
            paisesElegidos.push(element.value)
        }else{
            paisesElegidos.splice( paisesElegidos.indexOf( element.value ), 1 )
        }
        elementoPaises1.innerHTML = paisesElegidos.join(', ')

        document.getElementById("privilegios").value = paisesElegidos.join('&&')
    }
</script>

<script type="text/javascript" language="javascript" onclick="true">
    document.oncontextmenu = function(){return false}
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/validator/multifield.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/validator/validator.js"></script>

<!-- Javascript functions   -->
<script>
    function hideshow(){
        var password = document.getElementById("password1");
        var slash = document.getElementById("slash");
        var eye = document.getElementById("eye");

        if(password.type === 'password'){
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
        }
        else{
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";
        }

    }
</script>

<!-- Editar Menú -->
<script>
    $('.editbtnmenu').on('click',function () {
        $tr=$(this).closest('tr');
        var datos=$tr.children("td").map(function () {
            return $(this).text();
        });
        $('#name-up').val(datos[2]);
        $('#codigo-up').val(datos[3]);
    });
</script>
<!-- Fin Editar Menú -->

<!-- ------------------------------------------ -->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.0.2.min.js"></script>
<script type="text/javascript">
  $("tbody#itemlist").on("click","#borrar",function(){
      $(this).parent().parent().remove();
  });

  function clear (){
    $("#itemtitulo").val("");
    $("#itemtipo").val("");
    $("#itemmarca").val("");
    $("#itemmodelo").val("");
    $("#itemserie").val("");
    $("#itemcolor").val("");
    $("#itemcarac").val("");
    $("#itemcable").val("");
    $("#itemobs").val("");
    $("#itemestado").val("");

}

$('#anadir').on('click', function(e) {
  e.preventDefault();
  var itemtitulo = $("#itemtitulo").val();
  var itemtipo = $("#itemtipo").val();
  var itemmarca = $("#itemmarca").val();
  var itemmodelo = $("#itemmodelo").val();
  var itemserie = $("#itemserie").val();
  var itemcolor = $("#itemcolor").val();
  var itemcarac = $("#itemcarac").val();
  var itemcable = $("#itemcable").val();
  var itemobs = $("#itemobs").val();
  var itemestado = $("#itemestado").val();
  var items = "";
  items += "<tr>";
  items +="<td>Hardwares:</td>";
  items += "<td><input type='hidden' name='item[titulo][]' value='"+ itemtitulo +"'>"+itemtitulo +"</td>";
  items += "<td><input type='hidden' name='item[tipo][]' value='"+ itemtipo +"'>"+itemtipo +"</td>";
  items += "<td><input type='hidden' name='item[marca][]' value='"+ itemmarca +"'>"+itemmarca +"</td>";
  items += "<td><input type='hidden' name='item[modelo][]' value='"+ itemmodelo +"'>"+itemmodelo +"</td>";
  items += "<td><input type='hidden' name='item[serie][]' value='"+ itemserie +"'>"+itemserie +"</td>";
  items += "<td><input type='hidden' name='item[color][]' value='"+ itemcolor +"'>"+itemcolor +"</td>";
  items += "<td><input type='hidden' name='item[carac][]' value='"+ itemcarac +"'>"+itemcarac +"</td>";
  items += "<td><input type='hidden' name='item[cable][]' value='"+ itemcable +"'>"+itemcable +"</td>";
  items += "<td><input type='hidden' name='item[obs][]' value='"+ itemobs +"'>"+itemobs +"</td>";
  items += "<td><input type='hidden' name='item[estado][]' value='"+ itemestado +"'>"+itemestado +"</td>";
  items += "<td><input type='button' id='borrar' name='borrar' class='btn btn-secondary' value='Quitar'></td>";
  items += "</tr>";

  if ($("tbody#itemlist tr").length == 0)
  {
    $("#itemlist").append(items);
       // clear();
   }else{
    $("#itemlist").append(items);
        //    clear();
        return false;
    }
});

</script>
<!-- ------------------------------------------ -->



<!--------------------------------------------------->
<script type="text/javascript">
    function agregar(id) {
        console.log(id);
    //alert(id);
    //cedula = document.getElementById("cedula"+id).innerHTML;
    apellido = document.getElementById("apellido"+id).innerHTML;
    nombre = document.getElementById("nombre"+id).innerHTML;
    departamento = document.getElementById("departamento"+id).innerHTML;
    cargo = document.getElementById("cargo"+id).innerHTML;
    console.log(apellido);
    $("#apellido").val(apellido);
    $("#nombre").val(nombre);
    $("#departamento").val(departamento);
    $("#cargo").val(cargo);
    $("#bs-example-modal-lg").modal("hide");
}
</script>
<!--------------------------------------------------->



<!--------------------------------------------------->
<script type="text/javascript">
    function limpiar() {
        document.getElementById("itemtitulo").value = "";
        document.getElementById("itemtipo").value = "";
        document.getElementById("itemmarca").value = "";
        document.getElementById("itemmodelo").value = "";
        document.getElementById("itemserie").value = "";
        document.getElementById("itemcolor").value = "";
        document.getElementById("itemcarac").value = "";
        document.getElementById("itemcable").value = "";
        document.getElementById("itemobs").value = "";
        document.getElementById("itemestado").value = "";
    }
</script>
<!--------------------------------------------------->

<!-- jQuery -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->



<!-- Switchery -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/switchery/dist/switchery.min.js"></script>



<!-- Chart.js -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<!-- Skycons -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/Flot/jquery.flot.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/Flot/jquery.flot.pie.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/Flot/jquery.flot.time.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/Flot/jquery.flot.stack.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>



<!-- jQuery Smart Wizard -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>



<script src="<?php echo SERVERURL; ?>vistas/vendors/nprogress/nprogress.js"></script>
<!-- iCheck -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/iCheck/icheck.min.js"></script>
<!-- Datatables -->
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/jszip/dist/jszip.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/vendors/pdfmake/build/vfs_fonts.js"></script>
<!-- validator -->
<!-- <script src="../vendors/validator/validator.js"></script> -->

<!-- Custom Theme Scripts -->
<script src="<?php echo SERVERURL; ?>vistas/build/js/custom.min.js"></script>