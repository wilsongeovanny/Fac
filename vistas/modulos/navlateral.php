<?php
require_once './core/forced.php';
$codigo_cuenta=$_SESSION['codigo_gad'];
$consulta="SELECT *,T1.cuentacodigo FROM cuenta as T1, estado_cuenta as T2, roles as T3, privilegios as T4, modulo as T5 WHERE T1.cuentacodigo='$codigo_cuenta' AND T1.estadocuentacodigo=T2.estadocuentacodigo AND T1.codigoroles=T3.codigoroles AND T3.codigoroles=T4.codigoroles AND T4.modulocodigo=T5.modulocodigo";

$conexion = forced::conectar();

$datos = $conexion->query($consulta);
$datos= $datos->fetchAll();
?>


<?php
$contador=0;
$numerosencadena1 = "";
foreach ($datos as $rows) {
    $contador=$contador+1;

    //$zinc=forced::encryption($rows['modulocodigo']);
    $zinc=trim($rows['modulonombre']);

    ?>



    <!--<a href=""><?php echo $rows['modulonombre'] ?></a>-->


    <?php 
    $numerosencadena1 .=$zinc."*";
} 
?>



<!--<a href=""><?php echo $numerosencadena1 ?></a>-->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-home"></i> Tablero <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo SERVERURL; ?>home/">Tablero</a></li>
                    <!--<li><a href="<?php echo SERVERURL; ?>personal/">Informacación personal</a></li>-->
                    <li><a href="<?php echo SERVERURL; ?>perfil/">Información cuenta</a></li>
                </ul>
            </li>



            <?php

            $arreglo_cadena_detalles = explode("*", $numerosencadena1);

            for ($i=0; $i <count($arreglo_cadena_detalles) ; $i++) { 

                if ($arreglo_cadena_detalles[$i]=="Empresa") {
                    ?>
                    <li><a><i class="fa fa-institution"></i> Empresa <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo SERVERURL; ?>municipio/">Empresa</a></li>
                            <li><a href="<?php echo SERVERURL; ?>departamentos/">Departamentos</a></li>
                            <li><a href="<?php echo SERVERURL; ?>cargos/">Cargos</a></li>
                        </ul>
                    </li>
                    <?php
                }

                if ($arreglo_cadena_detalles[$i]=="Personal") {
                    ?>
                    <li><a><i class="fa fa-users"></i> Personal <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo SERVERURL; ?>empleados/">Empleados</a></li>
                            <li><a href="<?php echo SERVERURL; ?>estadosEmpleado/">Estados empleado</a></li>
                        </ul>
                    </li>
                    <?php
                }


                if ($arreglo_cadena_detalles[$i]=="Ingresos") {
                    ?>
                    <li><a><i class="fa fa-sign-in"></i> Ingresos <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a>Informes de Ingreso de Hardware<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo SERVERURL; ?>informeingresohardware/">Aprobados</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>informeingresoechazado/">Rechazados</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a>Características<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo SERVERURL; ?>tipohardware/">Tipos</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>marcashardware/">Marcas</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>modeloshardware/">Modelos</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>coloreshardware/">Colores</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="<?php echo SERVERURL; ?>estadosHardwareingreso/">Estados de ingreso</a></li>
                            <li><a href="<?php echo SERVERURL; ?>estadosHardware/">Estados de hardware</a></li>
                            <li><a href="<?php echo SERVERURL; ?>estadosHardwareasignacion/">Estados de re/asignación</a></li>
                        </ul>
                    </li>
                    <?php
                }

                if ($arreglo_cadena_detalles[$i]=="Re / Asignacion") {
                    ?>
                    <li><a><i class="fa fa-sign-out"></i> Re / Asignación <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a>Asignación<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo SERVERURL; ?>asignacion/">Sin asignar</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>asignados/">Asignados</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a>Reasignación<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo SERVERURL; ?>liberados/">Liberados</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>reasignados/">Reasignados</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                    <?php
                }

                if ($arreglo_cadena_detalles[$i]=="Mantenimiento") {
                    ?>
                    <li><a><i class="fa fa-bar-chart-o"></i> Mantenimiento <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a>Gestionar Mantenimiento<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo SERVERURL; ?>mantenimiento/">Hardware</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>reparacion/">En reparación</a>
                                    </li>
                                    <li><a href="<?php echo SERVERURL; ?>dadodebaja/">Dado de baja</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="<?php echo SERVERURL; ?>tiposMantenimiento/">Tipos de Mantenimiento</a></li>
                            <li><a href="<?php echo SERVERURL; ?>estadosMantenimiento/">Estados de Mantenimiento</a></li>
                        </ul>
                    </li>
                    <?php
                }

                if ($arreglo_cadena_detalles[$i]=="Administrador") {
                   ?>
                   <li><a><i class="fa fa-user"></i> Administradores <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php echo SERVERURL; ?>administrador/">Administrador</a></li>
                        <!--<li><a href="<?php echo SERVERURL; ?>perfil/">Perfil de usuario</a></li>-->
                        <li><a href="<?php echo SERVERURL; ?>estadosAdministrador/">Estados del administrador</a></li>
                    </ul>
                </li>
                <?php
            }



            if ($arreglo_cadena_detalles[$i]=="Accesos") {
                ?>
                <li><a><i class="fa fa-windows"></i> Accesos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php echo SERVERURL; ?>roles/">Roles</a></li>
                        <li><a href="<?php echo SERVERURL; ?>modulos/">Modulos</a></li>
                    </ul>
                </li>
                <?php
            }


        }


        ?>

    </div>
</div>